<?php

namespace App\Containers\AppSection\RentalInvoiceManual\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\RentalInvoiceManual\Models\RentalInvoiceManual;
use App\Containers\AppSection\RentalInvoiceManual\Tasks\CreateRentalInvoiceManualTask;
use App\Containers\AppSection\RentalInvoiceManual\UI\API\Requests\CreateRentalInvoiceManualRequest;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;

class CreateRentalInvoiceManualAction extends ParentAction
{
    use HashIdTrait;

    public function run(CreateRentalInvoiceManualRequest $request, $InputData)
    {

        $data = $request->sanitizeInput([
            //     "rent_id" => $InputData->getRentId(),
            "invoice_number" => $InputData->getInvoiceNumber(),
            "firm_name" => $InputData->getFirmName(),
            "property_name" => $InputData->getPropertyName(),
            "property_unit_name" => $InputData->getPropertyUnitName(),
            "invoice_type" => $InputData->getInvoiceType(),
            "invoice_date_gen" => $InputData->getInvoiceDateGen(),
            "amount_type" => $InputData->getAmountType(),
            "amount_total" => $InputData->getAmountTotal(),
            "pending_amount" => $InputData->getAmountTotal(),
            "transaction_number" => $InputData->getTransactionNumber(),
            "notes" => $InputData->getNotes(),
            "status" => $InputData->getStatus(),
            "transaction_date" => $InputData->getTransactionDate(),
            "due_date" => $InputData->getDueDate(),
            "email_sent" => 0,
            "property_owners_invoice" => 0,
        ]);
        $data['rent_id'] = $this->decode($InputData->getRentId());
        $data['property_id'] = $this->decode($InputData->getPropertyId());
        $data['property_unit_id'] = $this->decode($InputData->getPropertyUnitId());

        $invoice_details = $InputData->getInvoiceDetails();
        if (!empty($invoice_details)) {
            for ($j = 0; $j < count($invoice_details); $j++) {
                $rent_invoice_details[$j] = [
                    "amount" => $invoice_details[$j]['amount'],
                    "description" => $invoice_details[$j]['description'],
                    "is_tax_applied" => $invoice_details[$j]['is_tax_applied'],
                    "tax" => $invoice_details[$j]['tax'],
                    "tax_amount" => $invoice_details[$j]['tax_amount'],
                    "service_name" => $invoice_details[$j]['service_name'],
                    "status" => $invoice_details[$j]['status'],
                ];
            }
        }


        return app(CreateRentalInvoiceManualTask::class)->run($data, $rent_invoice_details);
    }
}
