import { Link } from "@inertiajs/react";
import React, { ReactNode } from "react";

const NavLink = ({
    href,
    pathname,
    children,
}: {
    href: string;
    pathname: string;
    children: ReactNode;
}) => {
    const currentPath = window.location.pathname;
    return (
        <Link
            href={href}
            className={`flex items-center gap-2 rounded-xl font-bold text-sm text-yellow-900 py-3 px-4 hover:bg-yellow-200 ${
                pathname == currentPath && "bg-yellow-200"
            }`}
        >
            {children}
        </Link>
    );
};

export default NavLink;
