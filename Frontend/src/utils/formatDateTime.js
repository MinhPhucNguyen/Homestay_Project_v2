export const formatDateTime = (createdAt) => {
    const datetime = new Date(createdAt);

    const day = datetime.getDate();
    const month = datetime.getMonth() + 1; // Months are zero-based in JavaScript
    const year = datetime.getFullYear();

    const hours = datetime.getHours();
    const minutes = datetime.getMinutes();
    const seconds = datetime.getSeconds();

    return `${day}/${month}/${year} ${hours}:${minutes}:${seconds}`;
};
