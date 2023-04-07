import {AppBar, Button, Container, Link, Toolbar, Typography} from "@mui/material";
import {Link as RouterLink} from 'react-router-dom'

const Layout = (props) => {
    return (
        <>
            <AppBar position="static">
                <Toolbar>
                    <Link sx={{flexGrow: 1}} component={RouterLink} to={'/'} underline={'none'} color={'inheriate'}>Todo
                        Manager</Link>
                    <div className={"flex justify-center items-center gap-4"}>
                        <Link component={RouterLink} to={'/add-todo'} underline={'none'} color={'inheriate'}>Add
                            Todo</Link>
                        <Link component={RouterLink} to={'/add-project'} underline={'none'} color={'inheriate'}>Add
                            Project</Link>
                    </div>
                </Toolbar>
            </AppBar>
            <Container>
                {
                    props.children
                }
            </Container>
        </>
    )
}

export default Layout