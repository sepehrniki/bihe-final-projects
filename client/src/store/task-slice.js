import {createSlice} from "@reduxjs/toolkit";

const initialState = {
    tasks: [],
    totalQuantity: 0,
};
const taskSlice = createSlice({
    name: "task",
    initialState,
    reducers: {
        replaceTasks(state, action) {
            state.items = action.payload.items;
            state.totalQuantity = action.payload.count;
        },
    },
});

export const taskActions = taskSlice.actions;
export default taskSlice.reducer;
