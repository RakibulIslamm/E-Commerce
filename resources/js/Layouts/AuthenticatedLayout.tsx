import { Head, Link } from "@inertiajs/react";
import { ReactNode } from "react";
import { CiShop } from "react-icons/ci";
import { IoHome } from "react-icons/io5";
import { RiListSettingsFill, RiUserSettingsFill } from "react-icons/ri";
import { LuUserCog } from "react-icons/lu";
import NavLink from "./NavLink";
import { Toaster } from "react-hot-toast";
import { User } from "@/types";

const AuthenticatedLayout = ({
    children,
    auth,
}: {
    children: ReactNode;
    auth: User;
}) => {
    return (
        <div className="bg-yellow-50 min-h-screen flex items-start relative">
            <Head title="Admin Dashboard" />
            <Toaster position="top-center" reverseOrder={false} />
            <aside className="w-[350px] shadow h-screen bg-white sticky top-0 left-0">
                <div className="flex flex-col justify-between h-full">
                    <div>
                        <div className="px-4 flex items-center justify-start border-b h-[60px]">
                            <h1 className="text-xl font-bold">e-Commerce</h1>
                        </div>
                        <div className="p-3 space-y-1">
                            <NavLink href="/dashboard" pathname="/dashboard">
                                <IoHome className="text-xl" />
                                <span>Home</span>
                            </NavLink>

                            {(auth?.role == 1 ||
                                auth?.role == 2 ||
                                auth?.role == 3) && (
                                <NavLink
                                    href={"/ecommerce"}
                                    pathname={"/ecommerce"}
                                >
                                    <CiShop className="text-xl" />
                                    <span>Ecommerces</span>
                                </NavLink>
                            )}

                            {(auth?.role == 1 || auth?.role == 5) && (
                                <NavLink
                                    href={"/ecommerce/requests"}
                                    pathname={"/ecommerce/requests"}
                                >
                                    <RiListSettingsFill className="text-xl" />
                                    <span>
                                        {auth?.role == 5
                                            ? "My Requests"
                                            : "Requests"}
                                    </span>
                                </NavLink>
                            )}

                            {auth?.role == 1 && (
                                <NavLink
                                    href={route("profile.edit")}
                                    pathname="/profile"
                                >
                                    <RiUserSettingsFill className="text-xl" />
                                    <span>Manage users</span>
                                </NavLink>
                            )}
                            <NavLink
                                href={route("profile.edit")}
                                pathname="/profile"
                            >
                                <LuUserCog className="text-xl" />
                                <span>Edit profile</span>
                            </NavLink>
                        </div>
                    </div>
                    <Link
                        href={route("logout")}
                        method="post"
                        as="button"
                        className="inline-flex items-center justify-center h-9 px-4 bg-gray-900 text-gray-300 hover:text-white text-sm font-semibold transition"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="1em"
                            height="1em"
                            fill="currentColor"
                            className=""
                            viewBox="0 0 16 16"
                        >
                            <path d="M12 1a1 1 0 0 1 1 1v13h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3V2a1 1 0 0 1 1-1h8zm-2 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
                        </svg>
                        <span className="font-bold text-sm ml-2">Logout</span>
                    </Link>
                </div>
            </aside>
            <main className="w-full h-full">
                <div className="w-full h-[60px] shadow-sm flex justify-between items-center bg-white border-b border-l sticky top-0 px-5">
                    {auth.role == 5 && (
                        <div>
                            <Link
                                className="px-4 py-1 bg-slate-200 rounded"
                                href="/request-an-ecommerce"
                            >
                                Request an ecommerce
                            </Link>
                        </div>
                    )}
                    <h3 className="text-2xl font-bold">{auth?.name}</h3>
                </div>
                <div className="w-full h-full flex justify-center items-center">
                    {children}
                </div>
            </main>
        </div>
    );
};

export default AuthenticatedLayout;
