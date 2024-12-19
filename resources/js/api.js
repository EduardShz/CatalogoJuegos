import axios from "axios";

const client = axios.create({
    baseURL: "/api",
    headers: {
        Accept: "application/json",
    },
});

// Apis de Plataformas
export const getPlatforms = async () => {
    const { data } = await client.get("platforms");
    return data;
};

// Apis de Géneros
export const getGenre = async (id) => {
    const { data } = await client.get(`genres/${id}`);
    return data;
};
export const getGenres = async (params) => {
    const { data } = await client.get("genres", { params });
    return data;
};
export const deleteGenre = async (id) => {
    await client.delete(`genres/${id}`);
};
export const storeGenre = async (data) => {
    await client.post("genres/store", data);
};
export const updateGenre = async (id, data) => {
    await client.put(`genres/${id}`, data);
};

// Apis de Creadores
export const getCreator = async (id) => {
    const { data } = await client.get(`creators/${id}`);
    return data;
};
export const getCreators = async (params) => {
    const { data } = await client.get("creators", { params });
    return data;
};
export const deleteCreator = async (id) => {
    await client.delete(`creators/${id}`);
};
export const storeCreator = async (data) => {
    await client.post("creators/store", data);
};
export const updateCreator = async (id, data) => {
    await client.put(`creators/${id}`, data);
};

// Apis de Juegos
export const getGame = async (id) => {
    const { data } = await client.get(`games/${id}/showI`);
    return data;
};
export const getShowGame = async (id) => {
    const { data } = await client.get(`games/${id}/showN`);
    return data;
};
export const getGames = async () => {
    const { data } = await client.get("games");
    return data;
};
export const deleteGame = async (id) => {
    await client.delete(`games/${id}`);
};
export const storeGame = async (data) => {
    await client.post("games/store", data);
};
export const updateGame = async (id, data) => {
    await client.put(`games/${id}`, data);
};

// Apis de Comentarios
export const getComments = async (id) => {
    const { data } = await client.get(`games/${id}/comments`);
    return data;
};
export const deleteComment = async (gId, cId) => {
    await client.delete(`games/${gId}/comments/${cId}`);
};
export const storeComment = async (id, data) => {
    await client.post(`games/${id}/comments`, data);
};
// export const updateGame = async (id, data) => {
//     await axios.put(`/api/games/${id}`, data);
// };

// Apis de Likes
export const toggleLikeGame = async (id) => {
    await client.post(`games/${id}/likes`);
};

// Apis de Usuarios
export const getUser = async () => {
    try {
        const token = localStorage.getItem("token"); // Obtener el token del localStorage
        if (!token) {
            throw new Error("No se encontró el token");
        }

        const response = await client.get("user", {
            headers: {
                Authorization: `Bearer ${token}`, // Agregar el token a la cabecera
            },
        });

        // Retornar los datos del usuario
        return response.data; // Esto debe incluir el username y otros datos si los necesitas
    } catch (error) {
        console.error("Error al obtener los datos del usuario:", error);
        return null;
    }
};
