import request from '../utilies/Request'

export function getDesigns(params) {
    return request({
        url: base_url+'/designs',
        method: 'get',
        params: params
    })
}
export function deleteDesign(id, storage){
    return request({
        url: base_url+'/designs/'+id+'/'+storage,
        method: 'DELETE',
    })
}
export function saveDesign(data) {
    return request({
        url: base_url+'/saveProject',
        method: 'POST',
        data: data
    })
}
