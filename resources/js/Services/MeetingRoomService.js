import axios from 'axios';

export default class MeetingRoomService {

    getAllRoom() {
        return axios.get('/mroom/showall').then(res => res.data);
    }
}