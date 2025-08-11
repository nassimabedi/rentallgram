# rentallgram

To run

```
docker build --network=host -t <test-image> .
docker run -d -p 8000:8000 --name <my-app> <test-image>```
