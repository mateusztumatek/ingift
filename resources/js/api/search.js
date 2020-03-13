import request from '../utilies/Request'

export function Search(params) {
    return request({
        url: base_url+'/search',
        method: 'get',
        params:params
    })
}
