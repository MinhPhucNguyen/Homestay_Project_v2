export const formatCurrency = (price) => {
   return new Intl.NumberFormat("it-IT", {
      style: "currency",
      currency: "VND",
      minimumFractionDigits: 0,
      maximumFractionDigits: 0
   }).format(price);
};
