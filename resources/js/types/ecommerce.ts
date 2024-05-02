export type EcommerceType = {
    id: number;
    domain: string;
    auth_username: string;
    auth_password: string;
    email: string;
    tax_code: string;
    phone: string;
    rest_api_user: string;
    rest_api_password: string;
    business_type: string;
    price_with_vat: boolean;
    decimal_places: number;
    size_color_options: boolean;
    product_stock_display: string;
    registration_process: string;
    accepted_payments: string[];
    offer_display: string;
    created_at: string;
    updated_at: string;
};