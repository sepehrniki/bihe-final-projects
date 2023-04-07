import {Button, TextField, Typography} from "@mui/material";
import AddIcon from '@mui/icons-material/Add';
import {useRef} from 'react'
import {useDispatch} from "react-redux";
import {taskActions} from "../store/task-slice";
import {useNavigate} from "react-router-dom";

const AddTodoPage = () => {
    const titleInput = useRef();
    const descriptionInput = useRef();
    const dispatch = useDispatch()
    const navigate = useNavigate();
    const addTodoHandler = () => {
        const enteredTitle = titleInput.current.value;
        const enteredDescription = descriptionInput.current.value;
        dispatch(taskActions.addTask({enteredTitle, enteredDescription}))
        navigate('/')
    }
    return (
        <>
            <Typography variant="h1" mb={4}>
                Add Todo
            </Typography>
            <div className={'flex flex-col gap-4'}>
                <TextField inputRef={titleInput} id="outlined-basic" label="Title" variant="outlined"/>
                <TextField
                    id="outlined-multiline-static"
                    label="Description"
                    multiline
                    rows={4}
                    inputRef={descriptionInput}
                />
                <Button onClick={addTodoHandler} startIcon={<AddIcon/>} variant={"contained"}> Add Todo</Button>
            </div>
        </>
    )
}
export default AddTodoPage;