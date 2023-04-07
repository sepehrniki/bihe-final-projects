import {Button, Card, CardActions, CardContent, IconButton, Link, TextField, Typography} from "@mui/material";
import EditIcon from '@mui/icons-material/Edit';
import {Link as RouterLink} from "react-router-dom";
import {useSelector} from 'react-redux';

const HomePage = () => {
    const {tasks} = useSelector((state) => state.task);
    console.log(tasks)
    return (
        <>
            <Typography variant="h1" mb={4}>
                Todos
            </Typography>
            <div className={'grid grid-cols-12 gap-4'}>
                {tasks.map((task) =>
                    <Card key={task.id} className={'col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3'}>
                        <CardContent>
                            <Typography sx={{fontWeight: 'bold'}} gutterBottom>
                                {task.title}
                            </Typography>
                            <Typography variant="body2">
                                {task.description}
                            </Typography>
                        </CardContent>
                        <CardActions className={'felx items-center justify-between'}>
                            <Button variant={'contained'} size="small">{task.status}</Button>
                            <Link component={RouterLink} to={`/edit-todo/${task.itemID}`} underline={'none'}
                                  color={'inheriate'}>
                                <EditIcon/>
                            </Link>
                        </CardActions>
                    </Card>
                )}
            </div>
            {tasks.length === 0 && <p>Nothing To Show!</p>}
        </>
    )
}
export default HomePage