export function chats(state,{data,links,meta}){
    state.chats = data;
    state.pagination = {...links,...meta}
}

export function chat(state, {data}) {
    state.chat = data;
}

export function errors(state,{data}) {
    state.errors = data.errors;
}
