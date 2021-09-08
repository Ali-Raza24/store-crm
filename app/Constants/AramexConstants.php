<?php


namespace App\Constants;


interface AramexConstants
{
    CONST PRODUCT_GROUP_DOM = 'DOM';        // Express
    CONST PRODUCT_GROUP_EXP = 'EXP';        // Domestic

    CONST PRODUCT_TYPE_OND = 'OND';         // Only for Product Group DOM
    CONST PRODUCT_TYPE_PDX = 'PDX';         // Priority Document Express
    CONST PRODUCT_TYPE_PPX = 'PPX';         // Priority Parcel Express
    CONST PRODUCT_TYPE_PLX = 'PLX';         // Priority Letter Express
    CONST PRODUCT_TYPE_DDX = 'DDX';         // Deferred Document Express
    CONST PRODUCT_TYPE_DPX = 'DPX';         // Deferred Parcel Express
    CONST PRODUCT_TYPE_GDX = 'GDX';         // Ground Document Express
    CONST PRODUCT_TYPE_GPX = 'GPX';         // Ground Parcel Express
    CONST PRODUCT_TYPE_EPX = 'EPX';         // Economy Parcel Express

    //Payment Method
    CONST PAYMENT_PREPAID = 'P';            // Prepaid
    CONST PAYMENT_COD = 'C';                // Collect
    CONST PAYMENT_THIRD_PARTY = '3';        // Third Party

    //Payment Options
    CONST PAYMENT_OPTIONS_ASCC = 'ASCC';    // Needs Shipper Account Number to be filled.
    CONST PAYMENT_OPTIONS_ARCC = 'ARCC';    // Needs Consignee Account Number to be filled

    //For PaymentType = P (it's nullable here)
    CONST PAYMENT_OPTIONS_CASH = 'CASH';    // CASH
    CONST PAYMENT_OPTIONS_ACCT = 'ACCT';    // Stands for Account
    CONST PAYMENT_OPTIONS_PPST = 'PPST';    // Stands for Prepaid Stock
    CONST PAYMENT_OPTIONS_CRDT = 'CRDT';    // Stands for Credit

    CONST SERVICES_COD = 'CODS';            // Cash on Delivery
    CONST SERVICES_FIRST = 'FIRST';         // First Delivery
    CONST SERVICES_FRDM = 'FRDM';           // Free Domicile
    CONST SERVICES_HFPU = 'HFPU';           // Hold for pick up
    CONST SERVICES_NOON = 'NOON';           // Noon Delivery
    CONST SERVICES_SIG = 'SIG';             // Signature Required
}
