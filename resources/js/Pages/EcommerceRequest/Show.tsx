import { PageProps } from "@/types";
import { EcommerceRequestType } from "./EcommerceRequest";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";

const Show = ({
    ecommerceRequest,
    auth,
}: PageProps<{ ecommerceRequest: EcommerceRequestType }>) => {
    return (
        <AuthenticatedLayout auth={auth.user}>
            <div className="w-8/12 bg-white shadow border my-10 p-5 space-y-4">
                <p className="text-lg">
                    <span className="font-bold">Company:</span>{" "}
                    {ecommerceRequest.company_name}
                </p>
                <p className="text-lg">
                    <span className="font-bold">Email:</span>{" "}
                    {ecommerceRequest.email}
                </p>
                <p className="text-lg">
                    <span className="font-bold">Domain:</span>{" "}
                    {ecommerceRequest.domain}
                </p>
                <p className="text-lg">
                    <span className="font-bold">VAT Number:</span>{" "}
                    {ecommerceRequest.vat_number}
                </p>
                <p className="text-lg">
                    <span className="font-bold">Business Type:</span>{" "}
                    {ecommerceRequest.business_type}
                </p>
            </div>
        </AuthenticatedLayout>
    );
};

export default Show;
