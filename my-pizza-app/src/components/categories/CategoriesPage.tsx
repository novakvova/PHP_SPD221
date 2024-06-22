import {useEffect, useState} from "react";
import axios from "axios";
import {ICategoryItem} from "./types.ts";
import {Link} from "react-router-dom";

const CategoriesPage = () => {
    const [data, setData] = useState<ICategoryItem[]>([]);

    useEffect(()=> {
        axios.get<ICategoryItem[]>("http://localhost:8000/api/categories")
            .then(resp=> {
                //console.log("list", resp.data);
                setData(resp.data);
            });
    },[]);

    return (
        <>
            <div className={"container mx-auto"}>
                <h1 className="text-center text-4xl font-bold">Категорії</h1>
                <Link to={"/create"}>
                    <button className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Додати
                    </button>
                </Link>

                <div className={"grid  place-items-center grid-cols-1  sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4"}>
                    {data.map(item => (
                        <div key={item.id} className="max-w-sm rounded overflow-hidden shadow-lg">
                            <img className="w-full"
                                 src={`http://localhost:8000/upload/300_${item.image}`}
                                 alt="Sunset in the mountains"/>
                            <div className="px-6 py-4">
                                <div className="font-bold text-xl mb-2 text-center">{item.name}</div>
                            </div>
                        </div>
                    ))}
                </div>
            </div>
        </>
    );
}

export default CategoriesPage;

