import request from '../utilies/Request'

export function creatorSettings(params) {
    return request({
        url: base_url+'/creator_settings',
        method: 'get',
        params: params
    })
}


