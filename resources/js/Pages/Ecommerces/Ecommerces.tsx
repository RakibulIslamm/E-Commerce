import { PageProps } from "@/types";
import { EcommerceType } from "@/types/ecommerce";
import { Link } from "@inertiajs/react";
import Ecommerce from "./Partials/Ecommerce";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";

const Ecommerces = ({
    ecommerces,
    auth,
}: PageProps<{ ecommerces: EcommerceType[]; success: string }>) => {
    return (
        <AuthenticatedLayout auth={auth.user}>
            <section className="py-1 bg-blueGray-50 w-full">
                <div className="w-full xl:w-8/12 mb-12 xl:mb-0 px-4 mx-auto mt-24">
                    <div className="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded ">
                        <div className="rounded-t mb-0 px-4 py-3 border-0">
                            <div className="flex flex-wrap items-center">
                                <div className="relative w-full px-2 max-w-full flex-grow flex-1">
                                    <h3 className="font-semibold text-xl text-blueGray-700">
                                        Ecommerces
                                    </h3>
                                </div>
                                {(auth.user.role == 1 ||
                                    auth.user.role == 3) && (
                                    <div className="relative w-full px-4 max-w-full flex-grow flex-1 text-right">
                                        <Link
                                            href="/ecommerce/create"
                                            className="bg-indigo-500 text-white active:bg-indigo-600 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                                            type="button"
                                        >
                                            Add New
                                        </Link>
                                    </div>
                                )}
                            </div>
                        </div>

                        <div className="block w-full overflow-x-auto">
                            <table className="items-center bg-transparent w-full border-collapse ">
                                <thead>
                                    <tr>
                                        <th className="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-[14px] uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                            Domain
                                        </th>
                                        <th className="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3text-[14px]s uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                            Email
                                        </th>
                                        <th className="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-[14px] uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left"></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    {ecommerces.map((ecommerce) => (
                                        <Ecommerce
                                            key={ecommerce.id}
                                            ecommerce={ecommerce}
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

export default Ecommerces;
