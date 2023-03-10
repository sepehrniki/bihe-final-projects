import {createSlice} from "@reduxjs/toolkit";

const initialState = {
    showSpinnerLoading: false,
    notification: {
        open: false,
        status: 'success',
        message: '',
        vertical: 'bottom',
        horizontal: 'right',
    },
};
const uiSlice = createSlice({
    name: "ui",
    initialState,
    reducers: {
        showNotification(state, action) {
            state.notification = {
                open: true,
                status: action.payload.status,
                message: action.payload.message,
                vertical: 'bottom',
                horizontal: 'right',
            };
        },
        hideNotification(state) {
            state.notification = {
                open: false,
                status: 'success',
                message: '',
                vertical: 'bottom',
                horizontal: 'right',
            };
        },
        showSpinnerLoading(state) {
            state.showSpinnerLoading = true;
        },
        hideSpinnerLoading(state) {
            state.showSpinnerLoading = false;
        },
    },
});

export const uiActions = uiSlice.actions;
export default uiSlice.reducer;
