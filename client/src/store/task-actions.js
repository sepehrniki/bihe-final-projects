import {uiActions} from "./ui-slice";
import {taskActions} from "./task-slice";


const DOMAIN = process.env.REACT_APP_BACKEND_URL;

export const fetchTasksData = (requestData) => {
    return async (dispatch) => {
        const {token} = requestData
        dispatch(uiActions.showSpinnerLoading())
        const fetchRequest = async () => {
            const response = await fetch(`${DOMAIN}/`, {
                method: "GET",
                headers: {
                    "Authorization": 'Bearer ' + token,
                    "Content-Type": "application/json",
                },
            });
            if (!response.ok) {
                throw new Error("Could not get Tasks.");
            }
            return await response.json();
        }
        try {
            let data = await fetchRequest()
            dispatch(taskActions.replaceTasks({
                items: data.data.files,
            }))
        } catch (e) {
            dispatch(uiActions.showNotification({
                status: 'error',
                message: 'Could not get Tasks.'
            }))
        }
    }
}

export const createTask = (requestData) => {
    return async (dispatch) => {
        const {token, title, description, project_id} = requestData
        dispatch(uiActions.showSpinnerLoading())
        const fetchRequest = async () => {
            const response = await fetch(`${DOMAIN}/task`, {
                method: "POST",
                body: JSON.stringify({
                    title,
                    description,
                    project_id,
                }),
                headers: {
                    "Authorization": 'Bearer ' + token,
                    "Content-Type": "application/json",
                },
            });
            const data = await response.json()
            if (!response.ok) {
                console.log(data);
                throw new Error(data.message || "Could not create Task.");
            }
            return data;
        }
        try {
            const data = await fetchRequest()
            console.log(data);
            dispatch(fetchTasksData({token}));
            dispatch(uiActions.showNotification({
                status: 'success',
                message: 'Task Created Successfully!'
            }))
        } catch (e) {
            dispatch(uiActions.showNotification({
                status: 'error',
                message: 'Could not create Task.'
            }))
        }
    }
}

export const editTask = (requestData) => {
    return async (dispatch) => {
        const {token, id, status} = requestData
        dispatch(uiActions.showSpinnerLoading())
        const fetchRequest = async () => {
            const response = await fetch(`${DOMAIN}/task`, {
                method: "PATCH",
                body: JSON.stringify({
                    id,
                    status,
                }),
                headers: {
                    "Authorization": 'Bearer ' + token,
                    "Content-Type": "application/json",
                },
            });
            const data = await response.json()
            if (!response.ok) {
                console.log(data);
                throw new Error(data.message || "Could not create Task.");
            }
            return data;
        }
        try {
            const data = await fetchRequest()
            console.log(data);
            dispatch(fetchTasksData({token}));
            dispatch(uiActions.showNotification({
                status: 'success',
                message: 'Task Created Successfully!'
            }))
        } catch (e) {
            dispatch(uiActions.showNotification({
                status: 'error',
                message: 'Could not create Task.'
            }))
        }
    }
}