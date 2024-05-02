import { PageProps } from "@/types";
import SingleRequest from "./Partial/SingleRequest";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";

export type EcommerceRequestType = {
    id: number;
    domain: string;
    business_type: string;
    vat_number: string;
    email: string;
    company_name: string;
};

const EcommerceRequest = ({
    requested_ecommerces,
    auth,
}: PageProps<{ requested_ecommerces: EcommerceRequestType[] }>) => {
    return (
        <AuthenticatedLayout auth={auth.user}>
            <section className="py-1 w-full">
                <div className="w-full xl:w-8/12 mb-12 xl:mb-0 px-4 mx-auto mt-10">
                    <div className="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded ">
                        <div className="rounded-t mb-0 px-4 py-3 border-0">
                            <div className="flex flex-wrap items-center">
                                <div className="relative w-full px-2 max-w-full flex-grow flex-1">
                                    <h3 className="font-semibold text-xl text-blueGray-700">
                                        Requested Ecommerces
                                    </h3>
                                </div>
                            </div>
                        </div>

                        <div className="block w-full overflow-x-auto">
                            <table className="items-center bg-transparent w-full border-collapse ">
                                <thead>
                                    <tr>
                                        <th className="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-[14px] uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                            Company
                                        </th>
                                        <th className="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3text-[14px]s uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                            Email
                                        </th>
                                        <th className="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-[14px] uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                            Domain
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    {requested_ecommerces?.length &&
                                        requested_ecommerces?.map((request) => (
                                            <SingleRequest
                                                key={request.id}
                                                ecommerceRequest={request}
                                            />
                                        ))}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </AuthenticatedLayout>
    );
};

export default EcommerceRequest;
