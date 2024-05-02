import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { PageProps } from "@/types";
import { Head, router, usePage } from "@inertiajs/react";
import { ChangeEvent, FormEvent, useState } from "react";

interface ValidationErrors {
    [key: string]: string;
}

const RequestForm = ({
    auth,
    errors,
    success,
}: PageProps<{ errors: ValidationErrors; success: string }>) => {
    const [formData, setFormData] = useState({
        // user_id: auth.user.id,
        domain: "",
        business_type: "B2C",
        vat_number: "",
        email: auth.user.email,
        company_name: "",
    });

    const handleChange = (
        e: ChangeEvent<HTMLInputElement | HTMLSelectElement>
    ) => {
        const { name, value } = e.target;
        delete errors[name];
        setFormData({
            ...formData,
            [name]: value,
        });
    };

    const props = usePage();
    console.log(props);

    const handleSubmit = (e: FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        // Handle form submission logic here
        router.post(route("request.store", formData));
        // console.log(formData);
    };
    return (
        <AuthenticatedLayout auth={auth.user}>
            <Head title="Request for e-commerce" />
            <div className="w-full h-screen flex justify-center items-center">
                <div className="w-6/12 mx-auto">
                    <h2 className="text-xl font-bold py-3 text-center">
                        Request for an E-commerce
                    </h2>
                    <form
                        onSubmit={handleSubmit}
                        className="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 border"
                    >
                        <div className="mb-4">
                            <label
                                className="block text-gray-700 text-sm font-bold mb-2"
                                htmlFor="domain"
                            >
                                Domain
                            </label>
                            <input
                                className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="domain"
                                type="text"
                                name="domain"
                                value={formData.domain}
                                onChange={handleChange}
                                placeholder="Domain"
                                required
                            />
                        </div>
                        <div className="mb-4">
                            <label
                                className="block text-gray-700 text-sm font-bold mb-2"
                                htmlFor="businessType"
                            >
                                Business Type
                            </label>
                            <select
                                className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="businessType"
                                name="business_type"
                                value={formData.business_type}
                                onChange={handleChange}
                                required
                            >
                                <option value="B2C">B2C</option>
                                <option value="B2B">B2B</option>
                                <option value="B2B Plus">B2B Plus</option>
                            </select>
                        </div>
                        <div className="mb-4">
                            <label
                                className="block text-gray-700 text-sm font-bold mb-2"
                                htmlFor="vatNumber"
                            >
                                VAT Number
                            </label>
                            <input
                                className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="vatNumber"
                                type="text"
                                name="vat_number"
                                value={formData.vat_number}
                                onChange={handleChange}
                                placeholder="VAT Number"
                                required
                            />
                        </div>
                        <div className="mb-4">
                            <label
                                className="block text-gray-700 text-sm font-bold mb-2"
                                htmlFor="email"
                            >
                                Email
                            </label>
                            <input
                                className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="email"
                                type="email"
                                name="email"
                                value={formData.email}
                                onChange={handleChange}
                                placeholder="Email"
                                required
                            />
                        </div>
                        <div className="mb-4">
                            <label
                                className="block text-gray-700 text-sm font-bold mb-2"
                                htmlFor="companyName"
                            >
                                Company Name
                            </label>
                            <input
                                className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="companyName"
                                type="text"
                                name="company_name"
                                value={formData.company_name}
                                onChange={handleChange}
                                placeholder="Company Name"
                                required
                            />
                        </div>
                        <div className="flex items-center justify-between">
                            <button
                                className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                                type="submit"
                            >
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </AuthenticatedLayout>
    );
};

export default RequestForm;
