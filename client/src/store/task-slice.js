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
        addTask(state, action) {
            const task = action.payload;
            console.log(task)
            state.tasks.push({
                itemID: state.tasks.length,
                title: task.enteredTitle,
                description: task.enteredDescription,
                status: 'Todo',
            });
        },
        editTask(state, action) {
            const task = action.payload
            const existingTask = state.tasks.find(
                (taskItem) => taskItem.itemID === task.id
            );
            existingTask.title = task.titleValue;
            existingTask.description = task.descriptionValue;
            existingTask.status = task.statusValue;
        },
    },
});

export const taskActions = taskSlice.actions;
export default taskSlice.reducer;
