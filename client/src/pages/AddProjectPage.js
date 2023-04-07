import {Button, TextField, Typography} from "@mui/material";
import AddIcon from '@mui/icons-material/Add';

const AddProjectPage = () => {
    return (
        <>
            <Typography variant="h1" mb={4}>
                Add Project
            </Typography>
            <div className={'flex flex-col gap-4'}>
                <TextField id="outlined-basic" label="Project Title" variant="outlined"/>
                <Button startIcon={<AddIcon/>} variant={"contained"}> Add Project</Button>
            </div>
        </>
    )
}
export default AddProjectPage;