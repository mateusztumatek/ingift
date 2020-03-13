import request from '../utilies/Request'

export function storeOrder(data) {
    return request({
        url: base_url+'/orders',
        method: 'post',
        data: data
    })
}
export function getOrder(hash, params) {
    return request({
        url: base_url+'/orders/'+hash,
        method: 'GET',
        params: params
    })
}

export function updateOrders(data) {
    return request({
        url: base_url+'/admin/orders/massive_update',
        method: 'POST',
        data: data
    })
}

