import request from '../utilies/Request'

export function getPatterns(params) {
    return request({
        url: base_url+'/patterns',
        method: 'get',
        params: params
    })
}
