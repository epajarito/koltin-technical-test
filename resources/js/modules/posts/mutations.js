export function posts(state,{data,links,meta}){
    state.posts = data;
    state.pagination = {...links,...meta}
}

export function post(state, {data}) {
    state.post = data;
}

export function errors(state,{data}) {
    state.errors = data.errors;
}
