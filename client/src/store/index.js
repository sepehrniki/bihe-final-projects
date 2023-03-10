import {configureStore} from "@reduxjs/toolkit";
import taskReducer from './task-slice';
import uiReducer from './ui-slice';

const store = configureStore({
    reducer: {
        task: taskReducer,
        ui: uiReducer,
    },
});
export default store;
