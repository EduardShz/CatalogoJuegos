import axios from 'axios'

const client = axios.create({
    baseURL: '/api',
    headers: {
        Accept: 'application/json'
    }
})

// Apis de Plataformas
export const getPlatforms = async () => {
    const { data } = await client.get('platforms')
    return data
}

// Apis de Géneros
export const getGenre = async (id) => {
    const { data } = await client.get(`genres/${id}`)
    return data
}
export const getGenres = async (params) => {
    const { data } = await client.get('genres', {params})
    return data
}
export const deleteGenre = async (id) => {
    await client.delete(`genres/${id}`)
}
export const storeGenre = async (data) => {
   await axios.post('/api/genres/store', data);
}
export const updateGenre = async (id, data) => {
   await axios.put(`/api/genres/${id}`, data);
}

// Apis de Creadores
export const getCreator = async (id) => {
    const { data } = await client.get(`creators/${id}`)
    return data
}
export const getCreators = async (params) => {
    const { data } = await client.get('creators', {params})
    return data
}
export const deleteCreator = async (id) => {
    await client.delete(`creators/${id}`)
}
export const storeCreator = async (data) => {
   await axios.post('/api/creators/store', data);
}
export const updateCreator = async (id, data) => {
   await axios.put(`/api/creators/${id}`, data);
}

// Apis de Juegos
export const getGame = async (id) => {
    const { data } = await client.get(`games/${id}/showI`)
    return data
}
export const getShowGame = async (id) => {
    const { data } = await client.get(`games/${id}/showN`)
    return data
}
export const getGames = async () => {
    const { data } = await client.get('games')
    return data
}
export const deleteGame = async (id) => {
    await client.delete(`games/${id}`)
}
export const storeGame = async (data) => {
    await axios.post('/api/games/store', data)
}
export const updateGame = async (id, data) => {
   await axios.put(`/api/games/${id}`, data);
}