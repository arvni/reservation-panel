import {Head} from "@inertiajs/react";
import {Container, CssBaseline, Typography} from "@mui/material";

const Success = () => {
  return <>
      <Head title="Welcome"/>
      <Container component="main" maxWidth="xs" sx={{
          minHeight: "100dvh",
          display: "flex",
          justifyContent: "center",
          alignItems: "center"
      }}>
          <Typography>You have successfully Verified</Typography>
          <CssBaseline/>
      </Container>
      </>;
}

export default Success;
