import request from '../utilies/Request'

export function getCart() {
    return request({
        url: base_url+'/cart',
        method: 'get',
    })
}
export function addToCart(item){
    return request({
        url: base_url+'/cart/add',
        method: 'POST',
        data: item,
    })
}

export function editCartItem(id, data){
    return request({
        url: base_url+'/cart/'+id,
        method: 'PUT',
        data: data,
    })
}
export function deleteCartItem(id){
    return request({
        url: base_url+'/cart/'+id,
        method: 'DELETE',
    })
}
