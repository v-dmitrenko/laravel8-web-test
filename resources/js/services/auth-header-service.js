export default function authHeader() {
    let token = localStorage.getItem('user-token');
    if (token) {
        return { Authorization: 'Bearer ' + token };
    } else {
        return {};
    }
}
