export function messages(state,{data,links,meta}){
    state.messages = data;
    state.pagination = {...links,...meta}
}

export function message(state, {data}) {
    state.message = data;
}

export function errors(state,{data}) {
    state.errors = data.errors;
}
