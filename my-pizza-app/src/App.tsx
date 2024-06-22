import './App.css'
import CategoriesPage from "./components/categories/CategoriesPage.tsx";
import {Route, Routes} from "react-router-dom";
import CategoryCreatePage from "./components/create";
function App() {

  return (
    <>
        <Routes>
            <Route path="/" >
                <Route index element={<CategoriesPage />} />
                <Route path={"create"} element={<CategoryCreatePage />} />
            </Route>
        </Routes>
    </>
  )
}

export default App
