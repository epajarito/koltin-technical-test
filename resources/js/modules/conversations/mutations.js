export function conversations(state,{data,links,meta}){
    state.conversations = data;
    state.pagination = {...links,...meta}
}

export function conversation(state, {data}) {
    state.conversation = data;
}

export function errors(state,{data}) {
    state.errors = data.errors;
}
