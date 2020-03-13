import Request from '../utilies/Request';

export function getBread(model, id, params) {
    return Request({
        url:'/bread/'+model+'/'+id,
        method:'get',
        params: params
    })
}
export function getBreads(model, params) {
    return Request({
        url:'/bread/'+model,
        method:'get',
        params: params,
    })
}
export function storeBread(model, data) {
    return Request({
        url:'/bread/'+model,
        method:'post',
        data: data
    })
}
export function editBread(model, data, id) {
    return Request({
        url:'/bread/'+model+'/'+id,
        method:'put',
        data: data
    })
}
export function deleteBread(model, id, data) {
    return Request({
        url:'/bread/'+model+'/'+id,
        method:'delete',
        data: data
    })
}
