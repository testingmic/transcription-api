<?php

/**
 * Handle the webhook
 * 
 * @param string $event
 * @param array $payload
 * 
 * @return array
 */
function webhook_events() {
    return [
        "customeridentification.failed" => "A customer ID validation has failed", 
        "customeridentification.success" => "A customer ID validation was successful",
        "dedicatedaccount.assign.failed" => "A DVA couldn't be created and assigned to a customer",
        "dedicatedaccount.assign.success" => "A DVA has been successfully created and assigned to a customer",
        "invoice.create" => "An invoice has been created for a subscription on your account. This usually happens 3 days before the subscription is due or whenever we send the customer their first pending invoice notification",
        "invoice.payment_failed" => "A payment for an invoice failed",
        "invoice.update" => "An invoice has been updated. This usually means we were able to charge the customer successfully. You should inspect the invoice object returned and take necessary action",
        "paymentrequest.pending" => "A payment request has been sent to a customer",
        "paymentrequest.success" => "A payment request has been paid for",
        "refund.failed" => "Refund cannot be processed. Your account will be credited with refund amount",
        "refund.pending" => "Refund initiated, waiting for response from the processor.",
        "refund.processed" => "Refund has successfully been processed by the processor.",
        "refund.processing" => "Refund has been received by the processor.",
        "subscription.create" => "A subscription has been created",
        "subscription.disable" => "A subscription on your account has been disabled",
        "subscription.expiring_cards" => "Contains information on all subscriptions with cards that are expiring that month. Sent at the beginning of the month, to merchants using Subscriptions",
        "subscription.not_renew" => "A subscription on your account's status has changed to non-renewing. This means the subscription will not be charged on the next payment date",
        "transfer.failed" => "A transfer you attempted has failed",
        "transfer.success" => "A successful transfer has been completed",
        "transfer.reversed" => "A transfer you attempted has been reversed",
    ];
}