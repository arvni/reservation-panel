import {useState} from "react";
import {Head, useForm} from '@inertiajs/react';
import {
    Box,
    Button,
    Card,
    CardActions,
    CardContent,
    Container,
    CssBaseline,
    Grid,
    IconButton,
    Slide,
    Stack,
    TextField,
    ToggleButton,
    ToggleButtonGroup,
    Typography
} from "@mui/material";
import {CountdownCircleTimer} from 'react-countdown-circle-timer'
import CodeField from "@/Components/CodeField.jsx";

const TimeCard = ({doctor, data, onSelect}) => {
    const handleChange = (_, v) => onSelect(v);
    return <Grid item xs={12}>
        <Card
            sx={{
                borderTopRightRadius: "50dvw",
                borderTopLeftRadius: "50dvw",
                borderBottomLeftRadius: "2em",
                borderBottomRightRadius: "2em",
                background: "rgba(0,0,0,0.11)"
            }}
        >
            <CardContent
                sx={{
                    display: "flex",
                    flexDirection: "column",
                    alignItems: "center",
                    p: 0
                }}
            >
                {doctor?.image && <img
                    src={doctor?.image}
                    style={{
                        borderRadius: "50%",
                        marginBottom: "1em",
                        width: "clamp(300px,100%,396px)",
                        height: "auto",
                    }}/>}
                <Typography>{doctor?.title}</Typography>
                <Typography>{doctor?.subtitle}</Typography>
                <Typography>{doctor?.specialty}</Typography>
            </CardContent>
            <CardActions>
                <ToggleButtonGroup
                    value={data?.time}
                    exclusive
                    sx={{
                        flexWrap: "wrap",
                        justifyContent: "space-around",
                        alignContent: "space-between",
                        alignItems: "stretch",
                        gap: "1em"
                    }}
                    onChange={handleChange}
                    aria-label="time"
                >
                    {doctor?.times.map(time => <ToggleButton disabled={time.disabled} key={time.id}
                                                             sx={{borderRadius: "2em !important"}}
                                                             value={time.id}
                                                             aria-label={time.title}>
                        {time.title}
                    </ToggleButton>)}
                </ToggleButtonGroup>
            </CardActions>
        </Card>
    </Grid>;
}

export default function Welcome({doctors}) {
    const [showResend, setShowResend] = useState(false)
    const {data, setData, post, processing, errors} = useForm({
        step: 1,
        doctor: null,
        firstName: "",
        lastName: "",
        mobile: "",
        email: "",
        time: null
    });
    const handleShowResend = () => {
        setShowResend(true)
    }
    const handleResendCode = () => {

    };
    const handleSubmit = e => {
        e.preventDefault();
        post(route("reserve"), {
            onSuccess: (e) => {
                console.log(e);
                setData(previousData => ({...previousData, step: previousData.step + 1}))
            }
        });
    }
    const handleSelectTime = (id) => setData((previousData) => ({
        ...previousData,
        time: id,
        step: previousData.step + 1
    }));
    const handleDoctorChange = (id) => () => {
        setData(previousData => ({
            ...previousData,
            doctor: doctors?.data[doctors?.data?.findIndex((item) => item.id === id)],
            step: data.step + 1
        }));
    }
    const handleChange = (e) => {
        setData(previousData => ({...previousData,[e.target.name]:e.target.value}));
    }
    return (
        <>
            <Head title="Welcome"/>
            <Container component="main" maxWidth="xs" sx={{
                minHeight: "100dvh",
                display: "flex",
                justifyContent: "center",
                alignItems: "center"
            }}>
                <CssBaseline/>
                <Slide in={data.step === 1} mountOnEnter unmountOnExit direction={"left"}>
                    <Box>
                        <Grid container spacing={2}>
                            {doctors.data.map(doctor => <Grid item xs={6} key={"doctor-" + doctor.id}>
                                <IconButton onClick={handleDoctorChange(doctor.id)} sx={{flexDirection: "column"}}>
                                    <img src={doctor.image}
                                         style={{maxWidth: "100%", borderRadius: "50%", marginBottom: "1em"}}/>
                                    <Typography>{doctor?.title}</Typography>
                                    <Typography>{doctor?.subtitle}</Typography>
                                    <Typography>{doctor?.specialty}</Typography>
                                </IconButton>
                            </Grid>)}
                        </Grid>
                    </Box>
                </Slide>
                <Slide in={data.step === 2} mountOnEnter unmountOnExit direction={"left"}>
                    <Box>
                        <Grid container spacing={2}>
                            <TimeCard doctor={data?.doctor} data={data} onSelect={handleSelectTime}/>
                        </Grid>
                    </Box>
                </Slide>
                <Slide in={data.step === 3} mountOnEnter unmountOnExit direction={"left"}>
                    <Box
                        sx={{
                            display: data.time ? 'flex' : "none",
                            flexDirection: 'column',
                            alignItems: 'center',
                        }}
                    >
                        <Typography component="h1" variant="h5">
                            Fill The Form
                        </Typography>
                        <Box component="form" onSubmit={handleSubmit} sx={{mt: 3}}>
                            <Grid container spacing={2}>
                                <Grid item xs={12} sm={6}>
                                    <TextField
                                        autoComplete="given-name"
                                        name="firstName"
                                        required
                                        fullWidth
                                        id="firstName"
                                        label="First Name"
                                        autoFocus
                                        error={errors?.firstName}
                                        helperText={errors.firstName}
                                        onChange={handleChange}
                                    />
                                </Grid>
                                <Grid item xs={12} sm={6}>
                                    <TextField
                                        required
                                        fullWidth
                                        id="lastName"
                                        label="Last Name"
                                        name="lastName"
                                        error={errors?.lastName}
                                        helperText={errors.lastName}
                                        onChange={handleChange}
                                        autoComplete="family-name"
                                    />
                                </Grid>
                                <Grid item xs={12}>
                                    <TextField
                                        value={data.mobile}
                                        inputMode={"numeric"}
                                        error={!!errors.mobile}
                                        helperText={errors?.mobile}
                                        required
                                        fullWidth
                                        name="mobile"
                                        label="Mobile No."
                                        id="mobile"
                                        autoComplete="mobile"
                                        onChange={handleChange}
                                    />
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
            </Container>
        </>
    );
}
