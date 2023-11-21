import {useForm} from '@inertiajs/react';
import {
    Avatar,
    Backdrop,
    Box,
    Button,
    Card,
    CardActions,
    CardContent,
    CircularProgress,
    FormControl,
    FormHelperText,
    Grid,
    InputAdornment,
    InputLabel,
    ListItem,
    ListItemAvatar,
    ListItemText,
    OutlinedInput,
    Slide,
    Stack,
    TextField,
    ToggleButton,
    ToggleButtonGroup,
    Typography
} from "@mui/material";
import Layout from "@/Layouts/Layout.jsx";

const TimeCard = ({doctor, data, onSelect}) => {
    const handleChange = (_, v) => {
        if (!doctor.times.find(item => item.id === v).disabled)
            onSelect(v, doctor);
    };
    return <Grid item xs={6} sx={{paddingTop: "0px !important"}}>
        <Card
            sx={{
                borderTopRightRadius: "25dvw",
                borderTopLeftRadius: "25dvw",
                borderBottomLeftRadius: "1.5em",
                borderBottomRightRadius: "1.5em",
                background: "rgba(255,255,255,0.35)"
            }}
        >
            <CardContent
                sx={{
                    display: "flex",
                    flexDirection: "column",
                    alignItems: "center",
                    p: 0,
                    color:"#fff"
                }}
            >
                {doctor?.image && <img
                    src={doctor?.image}
                    style={{
                        borderRadius: "50%",
                        marginBottom: "1em",
                        width: "100%",
                        height: "auto",
                    }}/>}
                <Typography fontWeight={"bold"}>{doctor?.title}</Typography>
                <Typography>{doctor?.subtitle}</Typography>
                <Typography fontWeight={"bold"}>{doctor?.specialty}</Typography>
            </CardContent>
            <CardActions sx={{px: "1px"}}>
                <ToggleButtonGroup
                    value={data?.time}
                    exclusive
                    sx={{
                        display: "flex",
                        flexWrap: "wrap",
                        justifyContent: "space-evenly",
                        alignContent: "space-between",
                        alignItems: "stretch",
                        gap: ".5em",
                    }}
                    onChange={handleChange}
                    aria-label="time"
                >
                    {doctor?.times.map(time => <ToggleButton disabled={time.disabled}
                                                             key={time.id}
                                                             sx={{
                                                                 borderRadius: "1em !important",
                                                                 px: .5,
                                                                 py: 0,
                                                                 fontWeight: "900",
                                                                 background: "#fff",
                                                                 fontSize: ".7rem",
                                                                 color: "#000"
                                                             }}
                                                             value={time.id}
                                                             aria-label={time.title}>
                        {time.title}
                    </ToggleButton>)}
                </ToggleButtonGroup>
            </CardActions>
        </Card>
    </Grid>;
}

function Welcome({doctors}) {
    const {data, setData, post, processing, errors, setError, clearErrors} = useForm({
        step: 1,
        name: "",
        mobile: "",
        doctor: null,
        email: "",
        time: null
    });
    const handleSubmit = e => {
        e.preventDefault();
        clearErrors();
        if (/^((\+|00)?968)?[279]\d{7}$/.test(data.mobile))
            post(route("reserve"), {
                onSuccess: () => {
                    setData(previousData => ({...previousData, step: previousData.step + 1}))
                }
            });
        else
            setError("mobile", "Please enter a valid mobile number")
    }
    const handleSelectTime = (id, doctor) => setData((previousData) => ({
        ...previousData,
        time: id,
        doctor,
        step: previousData.step + 1
    }));
    const handleChange = (e) => {
        setData(previousData => ({...previousData, [e.target.name]: e.target.value}));
    }
    const handleBack = () => setData(previousData => ({...previousData, step: 1}));
    return (<>
            <Slide in={data.step === 1} mountOnEnter unmountOnExit direction={"left"}>
                <Box sx={{position: "relative", display: "flex", flexDirection: "column", alignItems: "center"}}>
                    <Grid container sx={{gap: "8px", flexWrap: "nowrap",px:1}}>
                        {doctors.data.map(doctor => <TimeCard doctor={doctor} data={data} key={"dr-"+doctor.id}
                                                              onSelect={handleSelectTime}/>)}
                    </Grid>
                    <Typography mt={2} color={"#fff"}>Please choose a time</Typography>
                </Box>
            </Slide>
            <Slide in={data.step === 2} mountOnEnter unmountOnExit direction={"left"}>
                <Box
                    sx={{
                        display: data.time ? 'flex' : "none",
                        flexDirection: 'column',
                        alignItems: 'center',
                    }}
                >

                    <Box component="form" onSubmit={handleSubmit}
                         sx={{mt: 3, mx: 2, p: 4, background: "rgba(255,255,255,0.7)", borderRadius: 4}}>
                        <Stack direction={"row"} justifyContent={"space-between"} marginBottom={1}>
                            <Typography component="h1" variant="h5">
                                Fill The Form
                            </Typography>
                            <Button onClick={handleBack}>
                               Back
                            </Button>
                        </Stack>
                        <Grid container spacing={2}>
                            {data.doctor && <Grid item xs={12}>
                                <ListItem>
                                    <ListItemAvatar>
                                        <Avatar src={data?.doctor?.image}/>
                                    </ListItemAvatar>
                                    <ListItemText primary={data?.doctor?.title}
                                                  secondary={data?.doctor?.times?.find(item => item.id === data.time)?.title}/>
                                </ListItem>
                            </Grid>}
                            <Grid item xs={12}>
                                <TextField
                                    autoComplete="given-name"
                                    name="name"
                                    required
                                    fullWidth
                                    id="name"
                                    label="Name"
                                    autoFocus
                                    error={!!errors?.name}
                                    helperText={errors.name}
                                    onChange={handleChange}
                                />
                            </Grid>
                            <Grid item xs={12}>
                                <FormControl variant="outlined" fullWidth required>
                                    <InputLabel error={!!errors.mobile} htmlFor="outlined-adornment-mobile">Mobile
                                        No.</InputLabel>
                                    <OutlinedInput fullWidth
                                                   value={data.mobile}
                                                   inputMode={"numeric"}
                                                   error={!!errors.mobile}
                                                   helperText={errors?.mobile}
                                                   required
                                                   name="mobile"
                                                   autoComplete="mobile"
                                                   onChange={handleChange}
                                                   id="outlined-adornment-mobile"
                                                   startAdornment={
                                                       <InputAdornment position="start">
                                                           +968
                                                       </InputAdornment>
                                                   }
                                                   label="Mobile No."
                                    />
                                    <FormHelperText error={!!errors.mobile}>{errors?.mobile}</FormHelperText>
                                </FormControl>
                            </Grid>
                            <Grid item xs={12}>
                                <TextField
                                    error={!!errors?.email}
                                    helperText={errors?.email}
                                    fullWidth
                                    value={data.email}
                                    inputMode={"email"}
                                    id="email"
                                    label="Email Address"
                                    name="email"
                                    autoComplete="email"
                                    onChange={handleChange}
                                />
                            </Grid>
                        </Grid>
                        <Button
                            type="submit"
                            fullWidth
                            variant="contained"
                            sx={{mt: 3, mb: 2}}
                        >
                            Sign Up
                        </Button>
                    </Box>
                </Box>
            </Slide>
            <Backdrop open={processing}>
                <CircularProgress/>
            </Backdrop>
        </>
    );
}

Welcome.layout = (page) => <Layout children={page}/>
export default Welcome;
