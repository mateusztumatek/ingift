import request from '../utilies/Request'

export function getShipments(params) {
    return request({
        url: base_url+'/shipments',
        method: 'get',
        params: params
    })
}

