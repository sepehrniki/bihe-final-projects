import {Button, FormControl, InputLabel, MenuItem, MenuList, Select, TextField, Typography} from "@mui/material";
import AddIcon from '@mui/icons-material/Add';
import EditIcon from '@mui/icons-material/Edit';
import {useNavigate, useParams} from "react-router-dom";
import {useDispatch, useSelector} from "react-redux";
import {useRef, useState} from "react";
import {taskActions} from "../store/task-slice";

const EditTodoPage = () => {
    const {taskId} = useParams()
    const task = useSelector((state) => state.task.tasks[taskId]);
    const navigate = useNavigate();
    console.log(task)
    const [titleValue, setTitleValue] = useState(task.title);
    const [descriptionValue, setDescriptionValue] = useState(task.description);
    const [statusValue, setStatusValue] = useState(task.status);
    const dispatch = useDispatch()
    console.log(titleValue)
    const handleStatusChange = (e) => {
        setStatusValue(e.target.value)
        dispatch(taskActions.editTask({id: task.itemID, titleValue, descriptionValue, statusValue: e.target.value}))
        navigate('/')
    }
    const saveTaskHandler = () => {

    }
    return (
        <>
            <Typography variant="h1" mb={4}>
                Edit Task
            </Typography>
            <div className={'flex flex-col gap-4'}>
                <TextField value={titleValue} id="outlined-basic" label="Title"
                           variant="outlined"/>
                <TextField
                    id="outlined-multiline-static"
                    label="Description"
                    multiline
                    rows={4}
                    // inputRef={descriptionInput}
                    value={descriptionValue}
                />
                <FormControl fullWidth>
                    <InputLabel id="demo-simple-select-label">Status</InputLabel>
                    {statusValue === "Todo" &&
                        <Select
                            labelId="demo-simple-select-label"
                            id="demo-simple-select"
                            value={statusValue}
                            label="Status"
                            onChange={handleStatusChange}
                        >
                            <MenuItem value={"In Progress"}>In Progress</MenuItem>
                        </Select>
                    }
                    {statusValue === "Blocked" &&
                        <Select
                            labelId="demo-simple-select-label"
                            id="demo-simple-select"
                            value={statusValue}
                            label="Status"
                            onChange={handleStatusChange}
                        >
                            <MenuItem value={"Todo"}>Todo</MenuItem>
                        </Select>
                    }
                    {statusValue === "In QA" &&
                        <Select
                            labelId="demo-simple-select-label"
                            id="demo-simple-select"
                            value={statusValue}
                            label="Status"
                            onChange={handleStatusChange}
                        >
                            <MenuItem value={"Done"}>Done</MenuItem>
                        </Select>
                    }

                    {statusValue === "In Progress" &&
                        <Select
                            labelId="demo-simple-select-label"
                            id="demo-simple-select"
                            value={statusValue}
                            label="Status"
                            onChange={handleStatusChange}
                        >
                            <MenuItem value={"In QA"}>In QA</MenuItem>
                            <MenuItem value={"Blocked"}>Blocked</MenuItem>
                        </Select>
                    }
                    {statusValue === "Done" &&
                        <Select
                            labelId="demo-simple-select-label"
                            id="demo-simple-select"
                            value={statusValue}
                            label="Status"
                            onChange={handleStatusChange}
                        >
                            <MenuItem value={"Deployed"}>Deployed</MenuItem>
                        </Select>
                    }
                    {statusValue === "Deployed" &&
                        <Select
                            labelId="demo-simple-select-label"
                            id="demo-simple-select"
                            value={statusValue}
                            label="Status"
                            onChange={handleStatusChange}
                        >
                            <MenuItem value={"Deployed"}>Deployed</MenuItem>
                        </Select>
                    }
                </FormControl>
                <div className={'grid grid-cols-12 gap-4'}>
                    <Button onClick={saveTaskHandler} className={'col-span-12 md:col-span-6'} startIcon={<EditIcon/>}
                            variant={"contained"}> Edit
                        Todo</Button>
                    <Button onClick={() => navigate('/')} className={'col-span-12 md:col-span-6'} startIcon={<AddIcon/>}
                            variant={"outlined"}> Cancel</Button>
                </div>
            </div>
        </>
    )
}
export default EditTodoPage;