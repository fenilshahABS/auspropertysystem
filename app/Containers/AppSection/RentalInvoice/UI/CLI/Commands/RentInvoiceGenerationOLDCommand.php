<?php

namespace App\Containers\AppSection\RentalInvoice\UI\CLI\Commands;

use App\Containers\AppSection\RentalInvoice\Models\RentalInvoice;
use App\Containers\AppSection\RentalInvoice\Models\RentalInvoiceChild;
use App\Containers\AppSection\RentalPropertyManagement\Models\RentalPropertyManagement;
use App\Containers\AppSection\RentalPropertyManagement\Models\RentalPropertyManagementLateFees;
use App\Containers\AppSection\Themesettings\Models\Themesettings;
use App\Ship\Parents\Commands\ConsoleCommand;
use Log;
use DateTime;


/**
 * Class CreateAdminCommand
 *
 * @author  Johannes Schobel <johannes.schobel@googlemail.com>
 */
class RentInvoiceGenerationCommand extends ConsoleCommand
{

    protected $signature = 'apiato:RentInvoiceGeneration';

    protected $description = 'Rent Invoice';

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
        Log::info("Rent Invoice Cron ...Start");
        Log::info("Rent Invoice Cron date" . date('Y-m-d'));

        $date = date('Y-m-d');
        $currentDate = new DateTime($date);
        $getLateFeeLimit = Themesettings::select('rent_late_fees')->where('id', 1)->first();
        $getRentData = RentalPropertyManagement::select('id', 'rent_date', 'rent_frequency', 'rent_created_at', 'lease_start_date', 'lease_end_date', 'rent_amount')->get();

        if (!empty($getRentData) && count($getRentData) >= 1) {
            for ($i = 0; $i < count($getRentData); $i++) {

                $lease_start_date = new DateTime($getRentData[$i]->lease_start_date);
                $lease_end_date = new DateTime($getRentData[$i]->lease_end_date);
                if ($currentDate >= $lease_start_date  && $currentDate <= $lease_end_date) {
                    $checkExistEntry = RentalInvoice::where('rent_id', $getRentData[$i]->id)->orderBy('id', 'DESC')->first();
                    if (empty($checkExistEntry)) {
                        if ($getRentData[$i]->rent_frequency == "monthly") {

                            $rent_date = new DateTime($getRentData[$i]->rent_created_at);

                            $interval = $currentDate->diff($rent_date);

                            if ($interval->days >= 30) {
                                $invoiceData = [
                                    "rent_id" => $getRentData[$i]->id,
                                    "invoice_type" => "RN",
                                    "invoice_date_gen" => date('Y-m-d'),
                                    "amount_total" => $getRentData[$i]->rent_amount,
                                    "pending_amount" => $getRentData[$i]->rent_amount,
                                    "status" => 0,
                                ];

                                $insertInvoiceData = RentalInvoice::create($invoiceData);

                                $invoiceDataChild = [
                                    "rent_invoice_id" => $insertInvoiceData->id,
                                    "amount" => $getRentData[$i]->rent_amount,
                                    "description" => "Monthly Rent",
                                    "status" => 0
                                ];
                                $insertInvoiceChildData = RentalInvoiceChild::create($invoiceDataChild);
                            }
                        } elseif ($getRentData[$i]->rent_frequency == "yearly") {
                            $rent_date = new DateTime($getRentData[$i]->rent_created_at);
                            $interval = $currentDate->diff($rent_date);
                            if ($interval->days >= 365) {
                                $invoiceData = [
                                    "rent_id" => $getRentData[$i]->id,
                                    "invoice_type" => "RN",
                                    "invoice_date_gen" => date('Y-m-d'),
                                    "amount_total" => $getRentData[$i]->rent_amount,
                                    "pending_amount" => $getRentData[$i]->rent_amount,
                                    "status" => 0,
                                ];
                                $insertInvoiceData = RentalInvoice::create($invoiceData);
                                $invoiceDataChild = [
                                    "rent_invoice_id" => $insertInvoiceData->id,
                                    "amount" => $getRentData[$i]->rent_amount,
                                    "description" => "Yearly Rent",
                                    "status" => 0
                                ];
                                $insertInvoiceChildData = RentalInvoiceChild::create($invoiceDataChild);
                            }
                        }
                    } else {
                        $invoice_date_gen = new DateTime($checkExistEntry->invoice_date_gen);
                        $dayInterval = $currentDate->diff($invoice_date_gen);
                        $dayInterval = $dayInterval->days;

                        if ($checkExistEntry->status == 1) {

                            if ($getRentData[$i]->rent_frequency == "monthly") {
                                if ($dayInterval >= 30) {

                                    $invoiceData = [
                                        "rent_id" => $checkExistEntry->rent_id,
                                        "invoice_type" => "RN",
                                        "invoice_date_gen" => date('Y-m-d'),
                                        "amount_total" => $getRentData[$i]->rent_amount,
                                        "pending_amount" => $getRentData[$i]->rent_amount,
                                        "status" => 0,
                                    ];
                                    $insertInvoiceData = RentalInvoice::create($invoiceData);
                                    $invoiceDataChild = [
                                        "rent_invoice_id" => $insertInvoiceData->id,
                                        "amount" => $getRentData[$i]->rent_amount,
                                        "description" => "Monthly Rent",
                                        "status" => 0
                                    ];
                                    $insertInvoiceChildData = RentalInvoiceChild::create($invoiceDataChild);
                                }
                            } elseif ($getRentData[$i]->rent_frequency == "yearly") {

                                if ($dayInterval >= 365) {

                                    $invoiceData = [
                                        "rent_id" => $checkExistEntry->rent_id,
                                        "invoice_type" => "RN",
                                        "invoice_date_gen" => date('Y-m-d'),
                                        "amount_total" => $getRentData[$i]->rent_amount,
                                        "pending_amount" => $getRentData[$i]->rent_amount,
                                        "status" => 0,
                                    ];
                                    $insertInvoiceData = RentalInvoice::create($invoiceData);
                                    $invoiceDataChild = [
                                        "rent_invoice_id" => $insertInvoiceData->id,
                                        "amount" => $getRentData[$i]->rent_amount,
                                        "description" => "Yearly Rent",
                                        "status" => 0
                                    ];
                                    $insertInvoiceChildData = RentalInvoiceChild::create($invoiceDataChild);
                                }
                            }
                        } else {
                            $dataCheckExistance = RentalInvoiceChild::where('rent_invoice_id', $checkExistEntry->id)
                                ->whereDate('created_at', date('y-m-d'))
                                ->count();

                            if ($dataCheckExistance == 0) {

                                $max_late_fee_amount = $getRentData[$i]->rent_amount + $getLateFeeLimit->rent_late_fees;
                                $late_fee_penalty = RentalPropertyManagementLateFees::where('pro_rentals_property_management_id', $checkExistEntry->rent_id)
                                    ->get();
                                if (!empty($late_fee_penalty) && count($late_fee_penalty) >= 1) {

                                    for ($j = 0; $j < count($late_fee_penalty); $j++) {
                                        $getLateFeesSum = RentalInvoiceChild::where('rent_invoice_id', $checkExistEntry->id)->sum('amount');
                                        if ($late_fee_penalty[$j]->date_range_type == "range") {
                                            $date_range_value = explode(', ', $late_fee_penalty[$j]->date_range_value);
                                            if ($dayInterval > $date_range_value[1] && $dayInterval < ($date_range_value[1] + 2)) {
                                                if ($max_late_fee_amount > $getLateFeesSum) {
                                                    if (($getLateFeesSum + $late_fee_penalty[$j]->late_fees_amount) < $max_late_fee_amount) {
                                                        $invoiceDataChild = [
                                                            "rent_invoice_id" => $checkExistEntry->id,
                                                            "amount" => $late_fee_penalty[$j]->late_fees_amount,
                                                            "description" => 'Late Fee ' . $date_range_value[0] . ' to' . $date_range_value[1] . 'th',
                                                            "status" => 0
                                                        ];
                                                        $insertInvoiceChildData = RentalInvoiceChild::create($invoiceDataChild);
                                                    }
                                                }
                                            }
                                        } elseif ($late_fee_penalty[$j]->date_range_type == "daily") {
                                            if ($dayInterval > $late_fee_penalty[$j]->date_range_value) {
                                                if ($max_late_fee_amount > $getLateFeesSum) {
                                                    if (($getLateFeesSum + $late_fee_penalty[$j]->late_fees_amount) < $max_late_fee_amount) {
                                                        $invoiceDataChild = [
                                                            "rent_invoice_id" => $checkExistEntry->id,
                                                            "amount" => $late_fee_penalty[$j]->late_fees_amount,
                                                            "description" => 'Late Fee Day' . $dayInterval,
                                                            "status" => 0
                                                        ];
                                                        $insertInvoiceChildData = RentalInvoiceChild::create($invoiceDataChild);
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                                $getLateFeesSum = RentalInvoiceChild::where('rent_invoice_id', $checkExistEntry->id)->sum('amount');
                                $checkExistEntry->amount_total = $getLateFeesSum;
                                $checkExistEntry->pending_amount = $getLateFeesSum;
                                $checkExistEntry->save();
                            }
                        }
                    }
                }
            }
        }
        Log::info("Rent Invoice Cron...Finish");
    }
}
