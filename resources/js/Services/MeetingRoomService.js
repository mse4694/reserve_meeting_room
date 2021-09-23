import axios from 'axios';

export default class MeetingRoomService {

    getAllRoom() {
        return axios.get('/mroom/showall').then(res => res.data);
    }

    getAllDeleteRoom() {
        return axios.get('/mroom/showall_delete').then(res => res.data);
    }
}