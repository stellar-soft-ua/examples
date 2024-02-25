module.exports = (err, req, res, next) => {
  const isDev = process.env.NODE_ENV === 'development';

  const userMessage = isDev ? err.stack : 'Something is wrong with the endpoint, please notify the API owner!';

  handleError(err.message ?? userMessage);
  res.status(500).send(userMessage);
};
