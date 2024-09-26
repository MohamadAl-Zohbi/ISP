// searchUtils.js
import axios from 'axios';

export async function search(searchQuery) {
    let token = localStorage.getItem('token');
    try {
        const response = await axios.get(`http://localhost:8000/api/search`, {
            headers: {
                Authorization: `Bearer ${token}`,
            },
            params: {
                search: searchQuery,
            },
        });

        console.log(response.data);
        return JSON.stringify(response.data); // You can return the response to be used later
    } catch (error) {
        console.error("There was an error during the search:", error);
    }
}
