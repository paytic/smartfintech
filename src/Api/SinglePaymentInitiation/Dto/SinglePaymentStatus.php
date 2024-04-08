<?php

namespace Paytic\Smartfintech\Api\SinglePaymentInitiation\Dto;

/**
 * @see https://docs.pay.smartfintech.eu/#tag/Step-3-Payment-Status/operation/paymentStatusUsingGET
 */
class SinglePaymentStatus
{
    /**
     * SmartPay internal status, generated at the payment initiation before reaching the bank.
     */
    public const STATUS_INITIATED = 'INIT';

    /**
     * The payment request has been successfully initiated at the bank and is awaiting customer authorization.
     */
    public const STATUS_Received = 'RCVD';

    /**
     * SmartPay internal status. Payments for which the "Cancel" button has been clicked on the page, or those for which, after checking the status, it is INIT or RCVD, and 30 min have passed since payment creation, will be marked as "ABND". We consider that the user has not authorized the payment at time in the bank.
     */
    public const STATUS_ABANDONED = 'ABND';

    /**
     * Authentication and technical validation are successful. ING: Payment request passed authentication, select a payment account. The payment is pending the customer's authorization. Exception: Unicredit Bank sends this status right from the initiation of the payment, they do not have the RCVD status.
     */
    public const STATUS_ACCEPTED_TECHNICAL_VALIDATION = 'ACTC';

    /**
     * PSU has authorized the payment. The technical validation check has been successfully completed. The customer profile validation has also been successful.
     */
    public const STATUS_ACCEPTED_CUSTOMER_PROFILE = 'ACCP';

    /**
     * All the previous validations, such as technical profile validation, has been successfully made, and as a consequence the payment initiation has been accepted for execution.
     */
    public const STATUS_ACCEPTED_SETTLEMENT_IN_PROCESS = 'ACSP';

    /**
     * The payment is pending for additional checks/validations to be carried out and the status will be updated later.
     */
    public const STATUS_PENDING = 'PDNG';

    /**
     * Settlement of the debtor's account has been completed (final Status).
     */
    public const STATUS_ACCEPTED_SETTLEMENT_COMPLETED = 'ACSC';

    /**
     * Status received from the bank. The payment initiation / authorization has been declined. A payment request with the RJCT status cannot be authorized by the client anymore.
     */
    public const STATUS_REJECTED = 'RJCT';

    /**
     * The payment is cancelled before authorization. The payment has been cancelled by the PSU.
     */
    public const STATUS_CANCELLED = 'CANC';

    /**
     * Status of a payment which has been blocked by SmartPay.
     */
    public const STATUS_BLOCKED = 'BLOCKED';

    public static function needsRechecking(string $status): bool
    {
        return in_array($status, [
            self::STATUS_INITIATED,
            self::STATUS_Received,
            self::STATUS_ACCEPTED_TECHNICAL_VALIDATION,
            self::STATUS_ACCEPTED_CUSTOMER_PROFILE,
            self::STATUS_ACCEPTED_SETTLEMENT_IN_PROCESS,
            self::STATUS_PENDING,
        ]);
    }

    public static function isFinal(string $status): bool
    {
        return in_array($status, [
            self::STATUS_ACCEPTED_SETTLEMENT_COMPLETED,
            self::STATUS_REJECTED,
            self::STATUS_CANCELLED,
            self::STATUS_BLOCKED,
        ]);
    }

    public static function isSuccessful(string $status): bool
    {
        return $status === self::STATUS_ACCEPTED_SETTLEMENT_COMPLETED;
    }
}
