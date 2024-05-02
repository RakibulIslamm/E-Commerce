import { PageProps } from "@/types";
import { EcommerceType } from "@/types/ecommerce";

const Show = ({
    ecommerce,
}: PageProps<{ mode: string; ecommerce: EcommerceType }>) => {
    console.log(ecommerce);
    return <div></div>;
};

export default Show;
