import request from '../utilies/Request'

export function getCategories(params) {
    return request({
        url: base_url+'/categories',
        method: 'get',
        params: params
    })
}


