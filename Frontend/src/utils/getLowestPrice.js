export const getLowestPrice = (rooms) => {
    if(!rooms || rooms.length === 0) return 0;

    const prices = rooms.map(room => parseFloat(room.pricePerNight));

    return Math.min(...prices);
}