import logo from './logo.svg';
import './App.css';
import Layout from "./components/Layout";
import {Route, Routes} from "react-router-dom";
import HomePage from "./pages/HomePage";
import AddTodoPage from "./pages/AddTodoPage";
import AddProjectPage from "./pages/AddProjectPage";
import EditTodoPage from "./pages/EditTodoPage";

function App() {
    return (
        <Layout>
            <Routes>
                <Route path={"/"} element={<HomePage/>}/>
                <Route path={"/add-todo"} element={<AddTodoPage/>}/>
                <Route path={"/add-project"} element={<AddProjectPage/>}/>
                <Route path={"/edit-todo/:taskId"} element={<EditTodoPage/>}/>
            </Routes>
        </Layout>
    );
}

export default App;
