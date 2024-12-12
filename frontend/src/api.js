// src/api.js
import axios from "axios";

const API_URL = import.meta.env.VITE_API_URL;

export const fetchData = async (filters) => {
  const query = new URLSearchParams(filters).toString();
  const response = await axios.get(`${API_URL}/customers?${query}`);
  return response.data.payload;
};

export const createData = async (newItem) => {
  const token = localStorage.getItem("token");
  const response = await axios.post(
    `${API_URL}/customers`,
    { newItem, token },
    { headers: { "Content-Type": "application/x-www-form-urlencoded" } }
  );
  return response.data.payload;
};

export const updateData = async (id, updatedItem) => {
  const token = localStorage.getItem("token");
  const { name, email, pasword, city, state, zipcode, geolat, geolng } =
    updatedItem;
  const response = await axios.put(
    `${API_URL}/customers/${id}`,
    {
      name,
      email,
      pasword,
      city,
      state,
      zipcode,
      geolat,
      geolng,
      token,
    },
    // { headers: { "Content-Type": "application/x-www-form-urlencoded" } }
    { headers: { "Content-Type": "application/json" } }
  );
  return response;
};

export const deleteData = async (id) => {
  const token = localStorage.getItem("token");
  await axios.delete(`${API_URL}/customers/${id}`, token, {
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
  });
};

export const userLogin = async ({ email, password }) => {
  await axios.post(
    `${API_URL}/login`,
    { email, password },
    { headers: { "Content-Type": "application/x-www-form-urlencoded" } }
  );
};

export const userLogout = async () => {
  await axios.delete(`${API_URL}/logout`, {
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
  });
};
