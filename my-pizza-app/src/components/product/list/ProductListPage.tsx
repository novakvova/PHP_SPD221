import {useParams} from "react-router-dom";
import {useEffect} from "react";
import axios from "axios";

const ProductListPage = () => {
    const { id } = useParams<{ id: string }>();

    useEffect(() => {
        axios.get("http://localhost:8000/api/products?categoryId="+id)
            .then(resp => {
                console.log("list products", resp.data);
            });
    }, [id]);
    console.log("id ", id);
    return (
        <>
            <h1 className={"text-center text-4xl font-bold"}>Список продуктів</h1>
        </>
    )
}

export default ProductListPage;