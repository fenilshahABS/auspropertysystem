<?php

namespace App\Containers\AppSection\RentalInvoice\UI\CLI\Commands;

use App\Containers\AppSection\Propertymaster\Models\PropertymasterShareDetails;
use App\Containers\AppSection\RentalInvoice\Models\RentalInvoice;
use App\Containers\AppSection\RentalInvoice\Models\RentalOwnerShareInvoice;
use App\Containers\AppSection\Tenantusers\Models\Emailtemplate;
use App\Containers\AppSection\Themesettings\Models\Themesettings;
use App\Ship\Parents\Commands\ConsoleCommand;
use Log;

/**
 * Class CreateAdminCommand
 *
 * @author  Johannes Schobel <johannes.schobel@googlemail.com>
 */
class OwnerShareInvoiceGenerationCommand extends ConsoleCommand
{

    protected $signature = 'apiato:OwnerShareInvoiceGeneration';

    protected $description = 'OwnerShare Invoice';

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
        Log::info("OwnerShare Invoice Cron ...Start");
        Log::info("OwnerShare Invoice Cron date" . date('Y-m-d'));

        $date = date('Y-m-d');

        $email_template = Emailtemplate::where('task', 'admin_rent_invoice')->first();
        $theme_setting = Themesettings::where('id', 1)->first();

        $query = RentalInvoice::select(
            'pro_rentals_invoice.*',
            'pro_rentals_property_management.property_master_id',
            'pro_property_master.property_owner_commission_amount',
            'pro_property_master.property_owner_commission_percentage'
        )
            ->leftjoin('pro_rentals_property_management', 'pro_rentals_property_management.id', 'pro_rentals_invoice.rent_id')
            ->leftjoin('pro_property_master', 'pro_property_master.id', 'pro_rentals_property_management.property_master_id');
        // ->leftjoin('pro_property_master_details', 'pro_property_master_details.id', 'pro_rentals_property_management.pro_property_master_details_id');
        $getData = $query->where('pro_rentals_invoice.property_owners_invoice', '=', 0)->get();

        if (!empty($getData) && count($getData) >= 1) {
            for ($i = 0; $i < count($getData); $i++) {
                $property_owner_share = PropertymasterShareDetails::where('pro_property_master_id', $getData[$i]->property_master_id)->get();
                if (!empty($property_owner_share) && count($property_owner_share)) {
                    $admin_rent_commission = $getData[$i]->amount_total * ($getData[$i]->property_owner_commission_percentage / 100);


                    if ($admin_rent_commission >= $getData[$i]->property_owner_commission_amount) {

                        $deduct_admin_commission_amount = $admin_rent_commission;
                    } else {

                        $deduct_admin_commission_amount = $getData[$i]->property_owner_commission_amount;
                    }
                    $net_amount_after_admin_deduction = $getData[$i]->amount_total - $deduct_admin_commission_amount;

                    for ($j = 0; $j < count($property_owner_share); $j++) {
                        $owner_share_amount = $net_amount_after_admin_deduction * ($property_owner_share[$j]->ownership_share / 100);

                        $data_owner_share = [
                            "rent_invoice_id" => $getData[$i]->id,
                            "property_owner_id" => $property_owner_share[$j]->property_owner_id,
                            "owner_share_amount" => $owner_share_amount,
                            "status" => 0
                        ];
                        $create_owner_share = RentalOwnerShareInvoice::create($data_owner_share);
                    }
                    $updateRentalInvoice = RentalInvoice::where('id', $getData[$i]->id)->update(['property_owners_invoice' => 1]);
                }
            }
        }
        Log::info("OwnerShare Invoice Cron...Finish");
    }
}
