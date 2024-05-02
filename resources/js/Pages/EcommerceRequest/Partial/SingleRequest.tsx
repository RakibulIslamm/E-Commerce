import { PageProps } from "@/types";
import React from "react";
import { EcommerceRequestType } from "../EcommerceRequest";
import { Link } from "@inertiajs/react";

const SingleRequest = ({
    ecommerceRequest,
}: {
    ecommerceRequest: EcommerceRequestType;
}) => {
    return (
        <tr>
            <td className="border-t-0 px-6 align-middle border-l-0 border-r-0 text-[14px] whitespace-nowrap p-4 ">
                {ecommerceRequest.company_name}
            </td>
            <td className="border-t-0 px-6 align-center border-l-0 border-r-0 text-[14px] whitespace-nowrap p-4">
                {ecommerceRequest.email}
            </td>
            <td className="border-t-0 px-6 align-middle border-l-0 border-r-0 text-[14px] whitespace-nowrap p-4">
                <Link
                    // href={`/admin/ecommerce/show/${ecommerceRequest.id}`}
                    href={route("request.show", ecommerceRequest)}
                    className="bg-indigo-500 text-white active:bg-indigo-600 text-[14px] font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none ease-linear transition-all duration-150"
                    type="button"
                >
                    View details
                </Link>
            </td>
        </tr>
    );
};

export default SingleRequest;
