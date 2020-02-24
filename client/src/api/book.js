import request from "@/utils/request"

export function fetchAllBooks(params) {
  return request({
    url: "/book",
    params,
    method: "get"
  })
}

export function create(data) {
  return request({
    url: "/book/create",
    data,
    method: "post"
  })
}
