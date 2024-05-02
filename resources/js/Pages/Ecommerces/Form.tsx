import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { PageProps } from "@/types";
import { EcommerceType } from "@/types/ecommerce";
import { Link, router, useForm } from "@inertiajs/react";
import { FormEventHandler, useEffect } from "react";
import toast from "react-hot-toast";

interface FormInterface {
    id?: number;
    domain: string;
    auth_username: string;
    auth_password: string;
    email: string;
    tax_code: string;
    phone: string;
    rest_api_user: string;
    rest_api_password: string;
    business_type: string;
    product_stock_display: string;
    registration_process: string;
    offer_display: string;
    decimal_places: number;
    accepted_payments: string[];
    price_with_vat: boolean;
    size_color_options: boolean;
}

const Form = ({
    mode,
    ecommerce,
    auth,
}: PageProps<{ mode: string; ecommerce: EcommerceType }>) => {
    const { data, setData, post, processing, errors, wasSuccessful, put } =
        useForm<FormInterface>(
            ecommerce ?? {
                domain: "",
                auth_username: "",
                auth_password: "",
                email: "",
                tax_code: "",
                phone: "",
                rest_api_user: "",
                rest_api_password: "",
                business_type: "B2C",
                product_stock_display: "Text Only",
                registration_process: "Optional",
                offer_display: "View cut price",
                decimal_places: 0,
                accepted_payments: [],
                price_with_vat: false,
                size_color_options: false,
            }
        );

    const handleCheckbox = (e: React.ChangeEvent<HTMLInputElement>) => {
        const { value, checked } = e.target;
        let updatedValues: string[];

        if (checked) {
            // If the checkbox is checked, add its value to the array
            updatedValues = [...data.accepted_payments, value];
        } else {
            // If the checkbox is unchecked, remove its value from the array
            updatedValues = data.accepted_payments.filter(
                (item) => item !== value
            );
        }

        // Update form state with the updated array of selected values
        setData("accepted_payments", updatedValues);
    };

    const handleSubmit: FormEventHandler = (e) => {
        e.preventDefault();

        // console.log(data);
        if (mode == "create") post(route("ecommerce.create"));
        if (mode == "edit") put(route("ecommerce.update", ecommerce));
    };

    useEffect(() => {
        if (wasSuccessful) {
            toast.success("Success");
        }
    }, [wasSuccessful]);

    useEffect(() => {
        if (mode == "view") {
            const inputs = document.getElementsByTagName("input");
            const selects = document.getElementsByTagName("select");
            for (const input of inputs) {
                input.disabled = true;
            }
            for (const select of selects) {
                select.disabled = true;
            }
        }
    }, []);

    const handleDelete = () => {
        if (confirm("Are you sure you want to delete this post?")) {
            // No need to specify the method, InertiaLink automatically sends a DELETE request
            router.delete(route("ecommerce.delete", { ecommerce }));
        }
    };

    return (
        <AuthenticatedLayout auth={auth.user}>
            <div className="w-full p-6">
                {/* <Link
                    className="inline-block px-4 py-1 bg-blue-400 text-white mb-2 rounded"
                    href="/admin/ecommerce"
                >
                    {"<<"}Back
                </Link> */}
                <h2 className="py-3 text-xl font-bold">
                    {mode == "create"
                        ? "Create Ecommerce"
                        : mode == "edit"
                        ? "Edit Ecommerce"
                        : ""}
                </h2>
                <form
                    onSubmit={handleSubmit}
                    className="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 w-full space-y-3"
                >
                    {/* Part 1 */}
                    <div className="w-full flex justify-between items-start gap-3">
                        <div className="w-full">
                            <label
                                className="block text-gray-700 text-sm font-bold mb-2"
                                htmlFor="domain"
                            >
                                Domain
                            </label>
                            <input
                                className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                onChange={(e) =>
                                    setData("domain", e.target.value)
                                }
                                value={data.domain}
                                id="domain"
                                type="text"
                                placeholder="Domain"
                                required
                            />
                        </div>

                        <div className="w-full">
                            <label
                                className="block text-gray-700 text-sm font-bold mb-2"
                                htmlFor="auth_username"
                            >
                                Auth Username
                            </label>
                            <input
                                className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                onChange={(e) =>
                                    setData("auth_username", e.target.value)
                                }
                                id="auth_username"
                                value={data.auth_username}
                                type="text"
                                placeholder="Basic Auth Username"
                            />
                        </div>

                        <div className="w-full">
                            <label
                                className="block text-gray-700 text-sm font-bold mb-2"
                                htmlFor="auth_password"
                            >
                                Auth Password
                            </label>
                            <input
                                className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                onChange={(e) =>
                                    setData("auth_password", e.target.value)
                                }
                                value={data.auth_password}
                                id="auth_password"
                                type="password"
                                placeholder="Basic Auth Password"
                            />
                        </div>
                    </div>

                    {/* Part 2 */}

                    <div className="w-full flex justify-between items-start gap-3">
                        <div className="w-full">
                            <label
                                className="block text-gray-700 text-sm font-bold mb-2"
                                htmlFor="email"
                            >
                                Email
                            </label>
                            <input
                                className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                onChange={(e) =>
                                    setData("email", e.target.value)
                                }
                                value={data.email}
                                id="email"
                                type="email"
                                placeholder="Email"
                                required
                            />
                        </div>

                        <div className="w-full">
                            <label
                                className="block text-gray-700 text-sm font-bold mb-2"
                                htmlFor="tax_code"
                            >
                                Tax Code
                            </label>
                            <input
                                className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                onChange={(e) =>
                                    setData("tax_code", e.target.value)
                                }
                                value={data.tax_code}
                                id="tax_code"
                                type="text"
                                placeholder="Tax Code"
                                required
                            />
                        </div>

                        <div className="w-full">
                            <label
                                className="block text-gray-700 text-sm font-bold mb-2"
                                htmlFor="phone"
                            >
                                Phone
                            </label>
                            <input
                                className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                onChange={(e) =>
                                    setData("phone", e.target.value)
                                }
                                id="phone"
                                value={data.phone}
                                type="text"
                                placeholder="Phone"
                                required
                            />
                        </div>
                    </div>

                    {/* Part 3 */}
                    <div className="w-full flex justify-between items-start gap-3">
                        <div className="w-full">
                            <label
                                className="block text-gray-700 text-sm font-bold mb-2"
                                htmlFor="rest_api_user"
                            >
                                Rest API User
                            </label>
                            <input
                                className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                onChange={(e) =>
                                    setData("rest_api_user", e.target.value)
                                }
                                value={data.rest_api_user}
                                id="rest_api_user"
                                type="text"
                                placeholder="Rest API User"
                                required
                            />
                        </div>

                        <div className="w-full">
                            <label
                                className="block text-gray-700 text-sm font-bold mb-2"
                                htmlFor="rest_api_password"
                            >
                                Rest API Password
                            </label>
                            <input
                                className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                onChange={(e) =>
                                    setData("rest_api_password", e.target.value)
                                }
                                value={data.rest_api_password}
                                id="rest_api_password"
                                type="password"
                                placeholder="Rest API Password"
                                required
                            />
                        </div>
                        <div className="w-6/12">
                            <label
                                className="block text-gray-700 text-sm font-bold mb-2"
                                htmlFor="business_type"
                            >
                                Business Type
                            </label>
                            <select
                                className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                onChange={(e) =>
                                    setData("business_type", e.target.value)
                                }
                                id="business_type"
                                required
                            >
                                <option
                                    selected={
                                        data.business_type.toLowerCase() ==
                                        "B2C".toLowerCase()
                                    }
                                    value="B2C"
                                >
                                    B2C
                                </option>
                                <option
                                    selected={
                                        data.business_type.toLowerCase() ==
                                        "B2B".toLowerCase()
                                    }
                                    value="B2B"
                                >
                                    B2B
                                </option>
                                <option
                                    selected={
                                        data.business_type.toLowerCase() ==
                                        "B2B Plus".toLowerCase()
                                    }
                                    value="B2B Plus"
                                >
                                    B2B Plus
                                </option>
                            </select>
                        </div>
                    </div>

                    {/* Part 4 */}
                    <div className="w-full flex justify-between items-start gap-3">
                        <div className="w-full">
                            <label
                                className="block text-gray-700 text-sm font-bold mb-2"
                                htmlFor="product_stock_display"
                            >
                                Product Stock Display
                            </label>
                            <select
                                className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                onChange={(e) =>
                                    setData(
                                        "product_stock_display",
                                        e.target.value
                                    )
                                }
                                id="product_stock_display"
                                required
                            >
                                <option
                                    selected={
                                        data.product_stock_display ==
                                        "Text Only"
                                    }
                                    value="Text Only"
                                >
                                    Text Only
                                </option>
                                <option
                                    selected={
                                        data.product_stock_display ==
                                        "Text + Quantity"
                                    }
                                    value="Text + Quantity"
                                >
                                    Text + Quantity
                                </option>
                                <option
                                    selected={
                                        data.product_stock_display ==
                                        "Do not display"
                                    }
                                    value="Do not display"
                                >
                                    Do not display
                                </option>
                            </select>
                        </div>

                        <div className="w-full">
                            <label
                                className="block text-gray-700 text-sm font-bold mb-2"
                                htmlFor="registration_process"
                            >
                                Registration Process
                            </label>
                            <select
                                className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                onChange={(e) =>
                                    setData(
                                        "registration_process",
                                        e.target.value
                                    )
                                }
                                id="registration_process"
                                required
                            >
                                <option
                                    selected={
                                        data.registration_process == "Optional"
                                    }
                                    value="Optional"
                                >
                                    Optional
                                </option>
                                <option
                                    selected={
                                        data.registration_process == "Mandatory"
                                    }
                                    value="Mandatory"
                                >
                                    Mandatory
                                </option>
                                <option
                                    selected={
                                        data.registration_process ==
                                        "Mandatory with confirmation"
                                    }
                                    value="Mandatory with confirmation"
                                >
                                    Mandatory with confirmation
                                </option>
                            </select>
                        </div>
                        <div className="w-full">
                            <label
                                className="block text-gray-700 text-sm font-bold mb-2"
                                htmlFor="offer_display"
                            >
                                Offer Display
                            </label>
                            <select
                                className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                onChange={(e) =>
                                    setData("offer_display", e.target.value)
                                }
                                id="offer_display"
                                required
                            >
                                <option
                                    selected={
                                        data.offer_display == "View cut price"
                                    }
                                    value="View cut price"
                                >
                                    View cut price
                                </option>
                                <option
                                    selected={
                                        data.offer_display ==
                                        "Do not display the cut price"
                                    }
                                    value="Do not display the cut price"
                                >
                                    Do not display the cut price
                                </option>
                            </select>
                        </div>
                        <div className="w-full">
                            <label
                                className="block text-gray-700 text-sm font-bold mb-2"
                                htmlFor="decimal_places"
                            >
                                Decimal Places
                            </label>
                            <input
                                className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                onChange={(e) =>
                                    setData(
                                        "decimal_places",
                                        parseInt(e.target.value)
                                    )
                                }
                                value={data.decimal_places}
                                id="decimal_places"
                                type="number"
                                placeholder="Decimal Places"
                                min="0"
                                required
                            />
                        </div>
                    </div>

                    {/* Part 5 */}
                    <div className="flex justify-start items-start gap-10 pt-5">
                        <div>
                            <label
                                className="block text-gray-700 text-sm font-bold"
                                htmlFor="accepted_payments"
                            >
                                Accepted Payments
                            </label>

                            <div>
                                <input
                                    type="checkbox"
                                    className="mr-2 leading-tight"
                                    value="PayPal"
                                    checked={data.accepted_payments.includes(
                                        "PayPal"
                                    )}
                                    onChange={handleCheckbox}
                                    id="paypal"
                                />
                                <label className="text-sm" htmlFor="paypal">
                                    PayPal
                                </label>
                            </div>
                            <div>
                                <input
                                    type="checkbox"
                                    className="mr-2 leading-tight"
                                    value="Bank Transfer"
                                    checked={data.accepted_payments.includes(
                                        "Bank Transfer"
                                    )}
                                    onChange={handleCheckbox}
                                    id="bank_transfer"
                                />
                                <label
                                    className="text-sm"
                                    htmlFor="bank_transfer"
                                >
                                    Bank Transfer
                                </label>
                            </div>
                            <div>
                                <input
                                    type="checkbox"
                                    className="mr-2 leading-tight"
                                    value="Cash on Delivery"
                                    checked={data.accepted_payments.includes(
                                        "Cash on Delivery"
                                    )}
                                    onChange={handleCheckbox}
                                    id="cash_on_delivery"
                                />
                                <label
                                    className="text-sm"
                                    htmlFor="cash_on_delivery"
                                >
                                    Cash on Delivery
                                </label>
                            </div>
                            <div>
                                <input
                                    type="checkbox"
                                    className="mr-2 leading-tight"
                                    value="collection_and_payment_on_site"
                                    checked={data.accepted_payments.includes(
                                        "collection_and_payment_on_site"
                                    )}
                                    onChange={handleCheckbox}
                                    id="collection_and_payment_on_site"
                                />
                                <label
                                    className="text-sm"
                                    htmlFor="collection_and_payment_on_site"
                                >
                                    Collection and payment on site
                                </label>
                            </div>
                            {errors["accepted_payments"] && (
                                <p className="text-sm text-red-500">
                                    {errors["accepted_payments"]}
                                </p>
                            )}
                        </div>

                        <div className=" flex items-start gap-6">
                            <div>
                                <label className="block text-gray-700 text-sm font-bold">
                                    Price with VAT
                                </label>
                                <input
                                    type="checkbox"
                                    className="mr-2 leading-tight"
                                    checked={data.price_with_vat}
                                    onChange={(e) =>
                                        setData(
                                            "price_with_vat",
                                            e.target.checked
                                        )
                                    }
                                    id="price_with_vat"
                                />
                                <label
                                    className="text-sm"
                                    htmlFor="price_with_vat"
                                >
                                    Include VAT in price
                                </label>
                            </div>
                            <div>
                                <label className="block text-gray-700 text-sm font-bold">
                                    Size and Color Options
                                </label>
                                <input
                                    type="checkbox"
                                    className="mr-2 leading-tight"
                                    checked={data.size_color_options}
                                    onChange={(e) =>
                                        setData(
                                            "size_color_options",
                                            e.target.checked
                                        )
                                    }
                                    id="size_color_options"
                                />
                                <label
                                    className="text-sm"
                                    htmlFor="size_color_options"
                                >
                                    Enable size and color options
                                </label>
                            </div>
                        </div>
                    </div>

                    <div className="flex items-center justify-start gap-4">
                        <button
                            className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                            disabled={processing || mode == "view"}
                            type="submit"
                        >
                            {processing ? "Processing..." : "Save"}
                        </button>
                        {mode == "view" &&
                            (auth.user.role == 1 || auth.user.role == 2) && (
                                <Link
                                    href={`/ecommerce/edit/${data?.id}`}
                                    className=" text-gray-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline underline"
                                    type="button"
                                >
                                    Edit Data
                                </Link>
                            )}

                        {mode == "edit" && (
                            <Link
                                href={`/dashboard`}
                                className=" bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                                disabled={processing}
                            >
                                Cancel
                            </Link>
                        )}
                        {mode == "edit" && auth.user.role == 1 && (
                            <button
                                onClick={handleDelete}
                                className="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                                type="button"
                            >
                                {"Delete"}
                            </button>
                        )}
                    </div>
                </form>
            </div>
        </AuthenticatedLayout>
    );
};

export default Form;
