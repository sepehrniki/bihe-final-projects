import {uiActions} from "./ui-slice";
import {projectActions} from "./poject-slice";


const DOMAIN = process.env.BACKEND_URL;

export const fetchProjectsData = (requestData) => {
    return async (dispatch) => {
        dispatch(uiActions.showSpinnerLoading())
        console.log(requestData)
        const fetchRequest = async () => {
            const response = await fetch(`${DOMAIN}/`, {
                method: "GET",
                headers: {
                    "Authorization": 'Bearer ' + requestData.token,
                    "Content-Type": "application/json",
                },
            });
            if (!response.ok) {
                throw new Error("Could not get projects.");
            }
            return await response.json();
        }
        try {
            let data = await fetchRequest()
            dispatch(projectActions.replaceProjects({
                projects: data.data.projects,
            }))
        } catch (e) {
            dispatch(uiActions.showNotification({
                status: 'error',
                message: 'Failed to load files'
            }))
        }
    }
}
