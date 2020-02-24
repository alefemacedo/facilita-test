import request from "@/utils/request"

export function fetchAllReceipts(params) {
  return request({
    url: "/receipt",
    params,
    method: "get"
  })
}

export function fetch(params) {
  return request({
    url: "/receipt/fetch",
    params,
    method: "get"
  })
}

export function create(data) {
  return request({
    url: "/receipt/create",
    data,
    method: "post"
  })
}

export function remove(id) {
  return request({
    url: "/receipt/remove",
    data: {
      receipt_id: id,
      _method: "DELETE"
    },
    method: "post"
  })
}
