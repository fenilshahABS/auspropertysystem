<?php

namespace App\Containers\AppSection\RentalInvoice\UI\CLI\Commands;

use App\Containers\AppSection\RentalInvoice\Models\RentalInvoice;
use App\Containers\AppSection\Tenantusers\Models\Emailtemplate;
use App\Containers\AppSection\Themesettings\Models\Themesettings;
use App\Ship\Parents\Commands\ConsoleCommand;
use Log;
use DateTime;
use Illuminate\Support\Facades\Mail;
use Config;

/**
 * Class CreateAdminCommand
 *
 * @author  Johannes Schobel <johannes.schobel@googlemail.com>
 */
class SendRentInvoiceOnMailCommand extends ConsoleCommand
{

    protected $signature = 'apiato:SendRentInvoiceOnMail';

    protected $description = 'Sent Invoice Mail';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        Log::info("Sent Invoice Mail Cron ...Start");
        Log::info("Sent Invoice Mail Cron date" . date('Y-m-d'));

        $date = date('Y-m-d');

        $email_template = Emailtemplate::where('task', 'admin_rent_invoice')->first();
        $theme_setting = Themesettings::where('id', 1)->first();

        $query = RentalInvoice::select(
            'pro_rentals_invoice.*',
            'pro_property_master.property_name',
            'pro_property_master_details.units_name',
            'tenant_user.first_name as tenant_name'
        )
            ->leftjoin('pro_rentals_property_management', 'pro_rentals_property_management.id', 'pro_rentals_invoice.rent_id')
            ->leftjoin('pro_property_master', 'pro_property_master.id', 'pro_rentals_property_management.property_master_id')
            ->leftjoin('pro_property_master_details', 'pro_property_master_details.id', 'pro_rentals_property_management.pro_property_master_details_id')
            ->leftjoin('pro_tenantusers as tenant_user', 'tenant_user.id', 'pro_rentals_property_management.user_id');
        $getData = $query->where('pro_rentals_invoice.email_sent', '=', 0)->get();


        $counter = 1;
        if (!empty($getData) && count($getData) >= 1) {

            for ($i = 0; $i < count($getData); $i++) {

                $content = "";
                $content .= '<h3 style="text-align:center">Rent Invoice Details </h3>';
                $content .= '<table style="text-align: center; width: 100%;" border="1">
                            <thead style="background: #9A9AEB;">
                            <tr>
                            <th>Sr.No.</th>
                            <th>Invoice Generation Date</th>
                            <th>Property Name</th>
                            <th>Unit Name</th>
                            <th>Amount($)</th>
                            </tr>
                            </thead>
                            <tbody>';
                $content .= '<tr>';
                $content .= '<td>' . $counter . '</td>';
                $content .= '<td>' . $getData[$i]->invoice_date_gen . '</td>';
                $content .= '<td>' . $getData[$i]->property_name . '</td>';
                $content .= '<td>' . $getData[$i]->units_name . '</td>';
                $content .= '<td>$ ' . $getData[$i]->amount_total . '</td>';
                //     $content .= '<td>' . ($getData[$i]->status == 1 ? 'PAID' : 'PENDING') . '</td>';
                $content .= '</tr>';
                $content .= '</tbody></table>';

                // Mail Sent to Admin
                $replaceText = array(
                    '{tenant_name}'  => $getData[$i]->tenant_name,
                    '{content}'    => $content,
                    '{sitename}'   => $theme_setting->name,
                );
                $admin_email = explode(',', $theme_setting->email);
                for ($j = 0; $j < count($admin_email); $j++) {
                    $templateString       = strtr($email_template->message, $replaceText);
                    $datatenantuser['message']      = $templateString;
                    $subject              = $email_template->subject;
                    $datatenantuser['email']        =  $admin_email[$j];
                    $datatenantuser['name']         = $theme_setting->name;
                    $datatenantuser['sitename']     = $theme_setting->name;
                    $datatenantuser['tenantemail']     = $admin_email[$j];
                    $datatenantuser['system_link']     = $theme_setting->image_api_url;
                    $datatenantuser['tenantname']     = $theme_setting->name;
                    $datatenantuser['mobile']       = $theme_setting->mobile;
                    $datatenantuser['sitelogo'] =  ($theme_setting->black_logo) ? $theme_setting->image_api_url . $theme_setting->black_logo : "";


                    $config = array(
                        'driver'     => trim($theme_setting->mailer),
                        'host'       => trim($theme_setting->smtphost),
                        'port'       => trim($theme_setting->port),
                        'from'       => array('address' => $theme_setting->smtpemail, 'name' => $theme_setting->name),
                        'encryption' => $theme_setting->ssl_tls_type,
                        'username'   => trim($theme_setting->smtpemail),
                        'password'   => trim($theme_setting->smtppassword),
                        'sendmail'   => '/usr/sbin/sendmail -bs',
                    );
                    config::set('mail', $config);

                    Mail::send('appSection@tenantusers::tenantuser-registered', ['data' => $datatenantuser], function ($m) use ($datatenantuser, $subject) {
                        $m->to($datatenantuser['email'], $datatenantuser['name'])->subject($subject);
                        if (isset($datatenantuser['attacheFile'])) $m->attach($datatenantuser['attacheFile']);
                    });
                }

                $updateRentalInvoice = RentalInvoice::where('id', $getData[$i]->id)->update(['email_sent' => 1]);
            }
        }
        Log::info("Sent Invoice Mail Cron...Finish");
    }
}
