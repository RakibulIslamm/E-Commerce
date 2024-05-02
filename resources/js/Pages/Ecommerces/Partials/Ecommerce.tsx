import { EcommerceType } from "@/types/ecommerce";
import { Link } from "@inertiajs/react";
import React from "react";

const Ecommerce = ({ ecommerce }: { ecommerce: EcommerceType }) => {
    return (
        <tr>
            <td className="border-t-0 px-6 align-middle border-l-0 border-r-0 text-[14px] whitespace-nowrap p-4 ">
                {ecommerce.domain}
            </td>
            <td className="border-t-0 px-6 align-center border-l-0 border-r-0 text-[14px] whitespace-nowrap p-4">
                {ecommerce.email}
            </td>
            <td className="border-t-0 px-6 align-middle border-l-0 border-r-0 text-[14px] whitespace-nowrap p-4">
                <Link
                    href={`/ecommerce/show/${ecommerce.id}`}
                    className="bg-indigo-500 text-white active:bg-indigo-600 text-[14px] font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none ease-linear transition-all duration-150"
                    type="button"
                >
                    Details
                </Link>
            </td>
        </tr>
    );
};

export default Ecommerce;
