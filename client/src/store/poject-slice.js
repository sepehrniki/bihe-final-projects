import {createSlice} from "@reduxjs/toolkit";

const initialState = {
    projects: [],
    totalQuantity: 0,
};
const projectSlice = createSlice({
    name: "project",
    initialState,
    reducers: {
        replaceProjects(state, action) {
            state.items = action.payload.items;
            state.totalQuantity = action.payload.totalQuantity;
        },
    },
});

export const projectActions = projectSlice.actions;
export default projectSlice.reducer;
